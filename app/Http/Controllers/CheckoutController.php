<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        // Mockup data invoice setelah checkout
        $invoiceItems = [
            [
                'nama' => 'Laptop ASUS ROG Strix',
                'harga' => 18500000,
                'quantity' => 1
            ],
            [
                'nama' => 'Sepatu Running Nike Airmax',
                'harga' => 2200000,
                'quantity' => 2
            ]
        ];

        $noInvoice = "INV-" . date("Ymd") . "-" . rand(1000, 9999);
        
        // Hitung total bayar mockup
        $totalBayar = 18500000 + (2200000 * 2);

        return view('checkout', compact('invoiceItems', 'noInvoice', 'totalBayar'));
    }
}
