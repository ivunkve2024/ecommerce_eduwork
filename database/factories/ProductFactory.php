<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true); // Menghasilkan 3 kata acak untuk nama produk
        return [
            // 'category_id' tidak perlu didefinisikan di sini karena akan diatur langsung oleh Seeder relasional
            'name' => ucfirst($name),
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(100, 999), // Ditambah angka unik agar slug tidak bentrok
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->randomFloat(2, 50000, 5000000), // Harga acak antara Rp 50.000 s/d Rp 5.000.000
            'stock' => $this->faker->numberBetween(5, 100), // Stok acak antara 5 s/d 100
            'image' => 'products/default.jpg', // Placeholder nama file gambar
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
