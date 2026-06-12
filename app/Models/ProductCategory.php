<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Relasi One-to-Many: Satu kategori memiliki banyak Produk
     * Nama fungsi harus 'products' (jamak) agar sesuai dengan parameter di Seeder tadi
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }
}