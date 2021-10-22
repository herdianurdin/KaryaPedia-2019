<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;
Use App\Product;
use App\Order;
use App\OrderDetail;

class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		if (request()->user()->hasRole('admin')) {
			$userCount = DB::table('role_users')->where('role_id', '2')->count();
			$productCount = Product::count();
			$productOutStock = Product::where('stock', '<', '1')->count();
			$orderCount = Order::where('status', 'Menunggu Pembayaran')->count();

			return view('admin.index', [
				'userCount' => $userCount,
				'productCount' => $productCount,
				'productOutStock' => $productOutStock,
				'orderCount' => $orderCount
			]);
		} else {
			return redirect('/');
		}
	}

	public function product()
	{
		if (request()->user()->hasRole('admin')) {
			$products = Product::orderBy('id', 'DESC')->paginate(6)->onEachSide(5);
			return view('admin.product', ['products' => $products]);
		} else {
			return redirect('/');
		}
	}
	
	public function search(Request $request)
	{
		$products = Product::where('name', 'like', '%'.$request->q.'%')
		->orderBy('id', 'DESC')->paginate(6)->onEachSide(5);
		$request->flash();
		return view('admin.product', ['products' => $products]);
	}
	
	public function insertProduct(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|string|max:255',
			'category' => 'required',
			'image' => 'required|file|image|mimes:jpeg,jpg,png|max:2048',
			'weight' => 'required|numeric',
			'price' => 'required|numeric',
			'stock' => 'required|numeric|min:1'
		]);

		$image_file = $request->file('image');
		$image_name = strtolower(time()."_".$image_file->getClientOriginalName());

		$destination = "img";
		$image_file->move($destination, $image_name);

		Product::create([
			'name' => ucwords(strtolower($request->name)),
			'category' => $request->category,
			'image' => $image_name,
			'weight' => $request->weight,
			'price' => $request->price,
			'stock' => $request->stock,
			'permalink' => strtolower(str_replace(' ', '-', time()."-".$request->name))
		]);
		
		return redirect()->back()->with('message', 'Data Tersimpan!');
	}

	public function deleteProduct($id)
	{
		if (request()->user()->hasRole('admin')) {
			$orderDetail = OrderDetail::where('product_id', $id)->count();
			if ($orderDetail > 0) {
				return redirect('/admin/produk')
				->with('msgError', 'Data Tidak Dapat Dihapus!');
			}
			$product = Product::find($id);
			File::delete('img/'.$product->image);
	
			$product->delete();
			return redirect('/admin/produk')
			->with('message', 'Data Berhasil Dihapus!');
		} else {
			return redirect('/');
		}
	}

	public function updateProduct(Request $request, $id)
	{
		$this->validate($request, [
			'update_name' => 'required|string|max:255',
			'update_weight' => 'required|numeric',
			'update_price' => 'required|numeric',
			'update_stock' => 'required|numeric|min:1'
		]);

		$product = Product::find($id);
		if($request->update_category)
		{
			$this->validate($request, [
				'update_category' => 'required'
			]);

			$product->category = $request->update_category;
		}

		if($request->update_image)
		{
			$this->validate($request, [
				'update_image' => 'required|file|image|mimes:jpeg,jpg,png|max:2048'
			]);
			$image_file = $request->file('update_image');
			$image_name = strtolower(time()."_".$image_file->getClientOriginalName());
	
			$destination = "img";
			$image_file->move($destination, $image_name);
			$product->image = $image_name;
		}

		$product->name = ucwords(strtolower($request->update_name));
		$product->weight = $request->update_weight;
		$product->price = $request->update_price;
		$product->stock = $request->update_stock;

		$product->save();

		return redirect()->back()->with('message', 'Data Berhasil Diperbarui!');
	}

	public function transaction()
	{
		if (request()->user()->hasRole('admin')) {
			$orders = Order::orderBy('id', 'DESC')->paginate(6)->onEachSide(5);
			return view('admin.transaction', [
				'orders' => $orders
			]);
		} else {
			return redirect('/');
		}
	}

	public function transactionStatus($status)
	{
		if (request()->user()->hasRole('admin')) {
			$orders = Order::orderBy('id', 'DESC')
			->where('status', strtolower(str_replace('-', ' ', $status)))
			->paginate(6)->onEachSide(5);
			return view('admin.transaction', [
				'orders' => $orders
			]);
		} else {
			return redirect('/');
		}
	}

	public function transactionSearch(Request $request)
	{
		$orders = Order::where('recipient_name', 'like', '%'.$request->q.'%')
		->orderBy('id', 'DESC')->paginate(6)->onEachSide(5);
		$request->flash();
		return view('admin.transaction', [
			'orders' => $orders
		]);
	}

	public function transactionDetail($order_code)
	{
		if (request()->user()->hasRole('admin'))
		{
			$order = Order::where('order_code', $order_code)->first();			
			$orderList = OrderDetail::where('order_id', $order->id)->orderBy('id', 'DESC')->paginate(6)->onEachSide(5);
			return view('admin.transactionDetail', 
			[
				'orderList' => $orderList,
				'order' => $order
			]);
		} else {
			return redirect('/');
		}
	}

	public function transactionUpdate(Request $request, $id)
	{
		$order = Order::find($id);
		if ($request->status == 'Dikirim')
		{
			$this->validate($request, [
				'track_code' => 'required|not_in:0'
			]);
		}

		$order->track_code = $request->track_code;
		$order->status = $request->status;
		$order->save();

		return redirect()->back()->with('message', 'Status Pesanan Berhasil Diperbarui!');
	}

	public function transactionDelete($id)
	{
		if (request()->user()->hasRole('admin'))
		{
			$order = Order::find($id);
			if ($order->status != 'Dibatalkan') {
				return redirect()->back()->with('msgError', 'Pesanan Tidak Dapat Dihapus!');
			}

			$orderDetail = OrderDetail::where('order_id', $id)->get();
			foreach($orderDetail as $list) {
				$product = Product::find($list->product_id);
				$product->stock += $list->total_order;
				$product->update();
				$list->delete();
			}
			$order->delete();
			return redirect()->back()->with('message', 'Status Pesanan Berhasil Dihapus!');
		} else {
			return redirect('/');
		}
	}
}
