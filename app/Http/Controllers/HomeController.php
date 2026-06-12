<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua kategori untuk drop-down filter di view
        $categories = ProductCategory::all();
        
        // 2. Inisialisasi Query Builder (Jangan langsung dipanggil paginate-nya)
        $productQuery = Product::with('category')->latest();

        // 3. Kondisi filter kategori (Berdasarkan Slug)
        if ($request->has('category') && $request->category != '') {
            $productQuery->whereHas('category', function($query) use ($request) {
                $query->where('slug', $request->category);
            });
        }

        // 4. Perbaikan Typo: Kondisi filter pencarian nama
        if ($request->has('search') && $request->search != '') {
            $productQuery->where('name', 'like', '%' . $request->search . '%');
        }

        // 5. Eksekusi pagination di paling akhir setelah semua filter terkumpul
        $products = $productQuery->paginate(12);

        // 6. Kirim kedua variabel ke file home.blade.php
        return view('home', compact('products', 'categories'));
    }
}