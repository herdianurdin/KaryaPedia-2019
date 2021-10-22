<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)->orderBy('id', 'DESC')
        ->paginate(6)->onEachSide(5);
        return view('home.index', ['products' => $products]);
    }

    public function category($category)
    {
        $products = Product::where('category', '=', $category)
        ->where('stock', '>', 0)->orderBy('id', 'DESC')
        ->paginate(6)->onEachSide(5);
        return view('home.index', ['products' => $products]);
    }

    public function search(Request $request)
    {
        $products = Product::where('name', 'like', '%'.$request->q.'%')
        ->where('stock', '>', 0)->orderBy('id', 'DESC')
        ->paginate(6)->onEachSide(5);

        $request->flash();
        return view('home.index', ['products' => $products]);
    }

    public function detail($permalink)
    {
        $product = Product::where('permalink', '=', $permalink)->first();
        if ($product->stock == 0) {
            return redirect('/');
        } else {
            return view('home.detail', ['product' => $product]);
        }
    }
}