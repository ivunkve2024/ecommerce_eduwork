<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // PENTING: Import Trait ini
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory; // PENTING: Gunakan Trait ini agar Factory bisa berjalan

    /**
     * Kolom yang diizinkan untuk diisi secara massal.
     * Sesuaikan dengan nama kolom yang ada di migrasi tabel products Anda.
     */
    protected $fillable = [
        'product_category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
    ];

    /**
     * Relasi Inverse (Many-to-One): Produk ini milik sebuah Kategori
     * Nama fungsi 'category' akan menjadi properti dinamis (contoh: $product->category->name)
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
}