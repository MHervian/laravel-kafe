<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $carts = Cart::with(['product.galleries', 'user'])->where('users_id', Auth::user()->id)->get();

        // foreach($carts as $cart) {
        //     echo "<pre>";
        //     var_dump($cart->product->galleries->first());
        //     echo "</pre>";
        //     echo "========================================<br><br>";
        // }
        // return;
        
        return view('pages.cart',[
            'carts' => $carts
        ]);
    }

    public function delete(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        $cart->delete();

        // restore stock back
        $product = Product::find($request->id_product);
        $product->stock = intval($product->stock) + intval($request->amount);
        $product->save();
        
        return redirect()->route('cart');
    }
    
    public function success()
    {
        return view('pages.success');
    }
}
