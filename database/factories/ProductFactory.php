<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'category_id' => \App\Models\Category::factory(),
            'name' => fake()->words(3, true),
            'barcode' => fake()->ean13(),
            'price' => fake()->randomElement([5000, 10000, 15000, 20000, 25000, 50000, 100000]),
            'stock' => fake()->numberBetween(10, 100),
            'description' => fake()->sentence(),
        ];
    }
}
