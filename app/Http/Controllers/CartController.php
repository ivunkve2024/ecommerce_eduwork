<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function add(Request $request, int $id)
    {
        return view('cart.index')      ;
    }

    public function index()
    {
        // Mockup data item yang ceritanya sudah masuk ke keranjang
        if(Auth::check()){
            $cart_item = CartItem::wher('use_id', Auth::id())
                            ->where('product_id', $id)
                            ->first();
            if($cart_item){
                $cart_item->quantity += 1;
                $cart_item>save();            
            }else{
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quantity' => 1,
                ]);
            }
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
        }else{
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu'); 
        }
        }
 
}


