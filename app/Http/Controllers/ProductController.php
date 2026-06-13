<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Inisialisasi Query dasar dengan relasi kategori
        $productQuery = Product::with('category');

        // LOGIKA SEARCH: Cek jika ada inputan pencarian
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $productQuery->where(function($query) use ($searchTerm) {
                $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        // 2. Logika Sort Jauh Lebih Dinamis
        if ($request->has('sort') && $request->sort != '') {
            switch ($request->sort) {
                case 'price_low':
                    $productQuery->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $productQuery->orderBy('price', 'desc');
                    break;
                case 'stock_low':
                    $productQuery->orderBy('stock', 'asc');
                    break;
                case 'stock_high':
                    $productQuery->orderBy('stock', 'desc');
                    break;
                case 'best_seller':
                    // Mengurutkan berdasarkan kolom total penjualan (asumsi nama kolomnya 'sales_count' atau 'total_sales')
                    // Jika di tabel Anda belum ada, sementara diarahkan ke record terpopuler atau sesuaikan nama kolomnya
                    $productQuery->orderBy('id', 'asc'); 
                    break;
                default:
                    $productQuery->latest();
                    break;
            }
        } else {
            // Default jika tidak memilih sort: Tampilkan data produk terbaru
            $productQuery->latest();
        }

        // 3. Eksekusi Pagination (10 data) di baris paling akhir
        // Ditambahkan appends() agar ketika pindah halaman pagination, filter sort-nya tidak hilang
        $products = $productQuery->paginate(10)->appends($request->query());

        return view('product', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProductCategory::all(); // Ambil data kategori untuk pilihan dropdown
        return view('add_product', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'nullable|exists:product_categories,id',
            'description' => 'nullable|string',
        ]);

        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // <-- 2. TAMBAHKAN BARIS INI (Otomatis buat slug)
            'price' => $request->price,
            'stock' => $request->stock,
            'product_category_id' => $request->category_id,
            'description' => $request->description,
            'image' => 'default.jpg',
        ]);

        return redirect()->route('products.index')->with('success', 'Produk baru berhasil ditambahkan!');
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::all(); // Ambil semua kategori untuk dropdown edit
        
        // PERBAIKAN: Sesuaikan dengan nama file baru Anda (tanpa menulis .blade.php)
        return view('edit_product', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'nullable|exists:product_categories,id',
            'description' => 'nullable|string',
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'product_category_id' => $request->category_id, // Sesuaikan nama kolom foreign key Anda
            'description' => $request->description,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
