<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Order;
use App\OrderDetail;
use Auth;

class MemberController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function account()
	{
		if (request()->user()->hasRole('member'))
		{
			return view('member.account');
		} else {
			return redirect('/');
		}
	}

	public function updateAccount(Request $request)
	{
		$this->validate($request, [
			'name' => ['required', 'string', 'max:255']
		]);

		if ($request->email != Auth::user()->email)
		{
			$this->validate($request, [
				'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
			]);
		}

		$user = User::find(Auth::user()->id);
		$user->name = ucwords(strtolower($request->name));
		$user->email = strtolower($request->email);
		$user->address = strtoupper($request->address);
		$user->phone_number = $request->phone_number;
		
		if ($request->password) {
			$this->validate($request, [
				'password' => ['required', 'string', 'min:8', 'confirmed']
			]);

			$user->password = bcrypt($request->password);
		}

		$user->save();

		return redirect('/akun');
	}

	public function cart()
	{
		if (request()->user()->hasRole('member'))
		{
			$order = Order::where('user_id', Auth::user()->id)->where('status', '0')->first();
			if (empty($order)) {
				return view('member.cart');
			}
			
			$orderList = OrderDetail::where('order_id', $order->id)->orderBy('id', 'DESC')->paginate(6)->onEachSide(5);
			return view('member.cart', 
			[
				'orderList' => $orderList,
				'order' => $order
			]);
		} else {
			return redirect('/');
		}
	}

	public function addToCart(Request $request, $id)
	{
		$this->validate($request, [
			'total_order' => 'required|min:1|numeric'
		]);

		if (Auth::guest())
		{
			return redirect()->route('login');
		}

		$product = Product::find($id);
		$order = Order::where('user_id', Auth::user()->id)->where('status', '0')->first();

		$total_price = $product->price * $request->total_order;

		if (empty($order))
		{
			Order::create([
				'user_id' => Auth::user()->id,
				'total_price' => $total_price,
				'status' => 0,
				'unique_code' => mt_rand(100, 999),
			]);
		} else {
			$orderDetail = OrderDetail::where('order_id', $order->id)->where('product_id', $product->id)->first();
			if($orderDetail){
				$total_order = $request->total_order + $orderDetail->total_order;
				if($total_order > $product->stock)
				{
					return redirect('/keranjang')->with('msgError', 'Pesananan Gagal Dimasukkan ke Dalam Keranjang!');
				}
			}
			$order->total_price = $order->total_price + $total_price;
			$order->update();
		}

		$order = Order::where('user_id', Auth::user()->id)->where('status', '0')->first();
		$orderDetail = OrderDetail::where('order_id', $order->id)->where('product_id', $product->id)->first();

		if (empty($orderDetail))
		{
			OrderDetail::create([
				'product_id' => $product->id,
				'order_id' => $order->id,
				'total_order' => $request->total_order,
				'total_price' => $total_price
			]);
		} else {
			$total_price += $orderDetail->total_price;
			$total_order = $request->total_order + $orderDetail->total_order;

			$orderDetail->total_price = $total_price;
			$orderDetail->total_order = $total_order;
			$orderDetail->update();
		}

		return redirect('/keranjang')->with('message', 'Pesanan Berhasil Dimasukkan ke Keranjang!');
	}

	public function removeFromCart($id)
	{
		$orderDetail = OrderDetail::find($id);
		$order = Order::where('id', $orderDetail->order_id)->first();
		$orderCounter = OrderDetail::where('order_id', $order->id)->count();

		if($orderCounter == 1)
		{
			$order->delete();
		} else {
			$order->total_price = $order->total_price - $orderDetail->total_price;
			$order->update();
		}

		$orderDetail->delete();
		return redirect()->back()->with('msgInfo', 'Pesanan Berhasil Dihapus!');
	}

	public function checkout()
	{
		$order = Order::where('user_id', Auth::user()->id)->where('status', '0')->first();
		if (empty($order))
		{
			return redirect('/');
		}

		return view('member.checkout');

	}

	public function continueCheckout(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'address' => 'required',
			'courier_name' => 'required',
			'phone_number' => 'required'
		]);

		$user = User::find(Auth::user()->id);
		$user->name = ucwords(strtolower($request->name));
		$user->address = strtoupper($request->address);
		$user->phone_number = $request->phone_number;
		$user->save();

		$order = Order::where('user_id', Auth::user()->id)->where('status', '0')->first();
		$orderDetail = OrderDetail::where('order_id', $order->id)->get();
		$total_weight = 0;
		foreach($orderDetail as $list) {
			$total_weight += $list->total_order * $list->Product->weight;
		}

		$order->shipping_address = strtoupper($request->address);
		$order->courier_name = $request->courier_name;
		$order->recipient_name = ucwords(strtolower($request->name));
		$order->phone_number = $request->phone_number;
		if ($total_weight<=1000)
		{
			$order->shipping_price = 15000;
		} else if (($total_weight>1000) && ($total_weight<10000)) {
			$shipping_price = round($total_weight/1000) * 15000;
			$order->shipping_price = $shipping_price;
		} else if ($total_weight<=10000) {
			$order->shipping_price = 40000;
		} else {
			$shipping_price = round($total_weight/1000) * 40000;
			$order->shipping_price = $shipping_price;
		}
		$order->save();

		return redirect('/checkout/konfirmasi');
	}

	public function confirmCheckout()
	{
		if (request()->user()->hasRole('member'))
		{
			$order = Order::where('user_id', Auth::user()->id)->where('status', '0')->first();
			if (empty($order)) {
				return view('member.cart');
			}
			
			$orderList = OrderDetail::where('order_id', $order->id)->orderBy('id', 'DESC')->paginate(6)->onEachSide(5);
			return view('member.confirmCheckout', 
			[
				'orderList' => $orderList,
				'order' => $order
			]);
		} else {
			return redirect('/');
		}
	}

	public function orderNow()
	{
		$order = Order::where('user_id', Auth::user()->id)->where('status', '0')->first();
		$orderDetail = OrderDetail::where('order_id', $order->id)->get();
		foreach($orderDetail as $list) {
			if ($list->total_order > $list->Product->stock)
			{
				$order->total_price -= $list->total_price;
				$order->update();
				
				$list->delete();
				return redirect('/keranjang')->with('msgError', 'Pesananan Melebihi Stok Produk!');
			}
		}

		foreach($orderDetail as $list) {
			$product = Product::find($list->product_id);
			$product->stock -= $list->total_order;
			$product->update();
		}

		$order->status = 'Menunggu Pembayaran';
		$order->order_code = 'KP-'.str_pad($order->id, 5, '0', STR_PAD_LEFT);
		$order->update();

		return redirect('/transaksi');
	}

	public function transaction()
	{
		if (request()->user()->hasRole('member'))
		{
			$orders = Order::where('user_id', Auth::user()->id)
					->where('status', '<>', '0')
					->orderBy('id', 'DESC')->paginate(6)->onEachSide(5);
			return view('member.transaction', 
			[
				'orders' => $orders
			]);
		} else {
			return redirect('/');
		}
	}

	public function transactionDetail($order_code)
	{
		if (request()->user()->hasRole('member'))
		{
			$order = Order::where('order_code', $order_code)->first();			
			$orderList = OrderDetail::where('order_id', $order->id)->orderBy('id', 'DESC')->paginate(6)->onEachSide(5);
			return view('member.transactionDetail', 
			[
				'orderList' => $orderList,
				'order' => $order
			]);
		} else {
			return redirect('/');
		}	
	}
}
