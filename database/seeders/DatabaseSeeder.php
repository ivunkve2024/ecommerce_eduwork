<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProductCategory; // PENTING: Jangan lupa import model ini
use App\Models\Product;         // PENTING: Jangan lupa import model ini
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 2. Tambahkan kode otomatisasi Kategori & Produk Anda di sini
        ProductCategory::factory()
            ->count(5)
            ->has(Product::factory()->count(10), 'products')
            ->create();
    }
}
