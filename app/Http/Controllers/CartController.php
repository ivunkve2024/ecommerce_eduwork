<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Mockup data item yang ceritanya sudah masuk ke keranjang
        $cartItems = [
            [
                'nama' => 'Laptop ASUS ROG Strix',
                'harga' => 18500000,
                'quantity' => 1,
                'gambar' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=500&auto=format&fit=crop&q=60'
            ],
            [
                'nama' => 'Sepatu Running Nike Airmax',
                'harga' => 2200000,
                'quantity' => 2,
                'gambar' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&auto=format&fit=crop&q=60'
            ]
        ];

        return view('cart', compact('cartItems'));
    }
}

