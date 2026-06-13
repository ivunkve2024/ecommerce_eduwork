<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Inisialisasi awal query beserta fungsi agregasi hitung manualnya
        $categoryQuery = ProductCategory::withCount('products as product_count')
            ->withSum('products as total_stock', 'stock')
            ->withSum('products as total_value', DB::raw('price * stock'));

        // 2. Jalankan logika pengurutan dinamis berdasarkan input user
        if ($request->has('sort') && $request->sort != '') {
            switch ($request->sort) {
                case 'count_high':
                    $categoryQuery->orderBy('product_count', 'desc');
                    break;
                case 'count_low':
                    $categoryQuery->orderBy('product_count', 'asc');
                    break;
                case 'value_high':
                    $categoryQuery->orderBy('total_value', 'desc');
                    break;
                case 'value_low':
                    $categoryQuery->orderBy('total_value', 'asc');
                    break;
                case 'stock_high':
                    $categoryQuery->orderBy('total_stock', 'desc');
                    break;
                case 'stock_low':
                    $categoryQuery->orderBy('total_stock', 'asc');
                    break;
                default:
                    $categoryQuery->latest();
                    break;
            }
        } else {
            // Default jika tidak memilih sort: Urutkan berdasarkan data terbaru dibuat
            $categoryQuery->latest();
        }

        // 3. Eksekusi pagination dan kunci parameternya agar tidak hilang saat pindah halaman
        $categories = $categoryQuery->paginate(10)->appends($request->query());

        return view('category', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        //
    }
}
