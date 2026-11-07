<?php

namespace App\Modules\Suppliers\Catalog\Database\Factories;

use App\Modules\Suppliers\Catalog\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'sku' => strtoupper(fake()->bothify('SKU-####')),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 1, 5000),
            'currency' => 'USD',
            'moq' => fake()->numberBetween(1, 100),
            'stock' => fake()->numberBetween(0, 10000),
            'is_active' => true,
        ];
    }
}
