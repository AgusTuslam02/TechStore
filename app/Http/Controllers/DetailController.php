<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Cart;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request,$id)
    {
        $product = Product::with(['galleries','user'])->where('slug',$id)->firstOrFail();
        // dd($product);
        return view('pages.details',[
            'product' => $product
        ]);
    }

    public function add($id)
    {
        $data = [
            'products_id' => $id,
            'users_id' => Auth::user()->id,
        ];
        // dd($data);
        Cart::create($data);
        return redirect('/cart');
    }
    
}
