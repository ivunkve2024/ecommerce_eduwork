<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Model>
 */
class ProductCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement([
            'Elektronik', 
            'Pakaian Pria', 
            'Pakaian Wanita', 
            'Sepatu & Sandal', 
            'Buku & Alat Tulis'
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            ];
        }
}
