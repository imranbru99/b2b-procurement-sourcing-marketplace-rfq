<?php

namespace App\Modules\Suppliers\Catalog\Database\Factories;

use App\Modules\Suppliers\Catalog\Models\ProductPriceTier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductPriceTier>
 */
class ProductPriceTierFactory extends Factory
{
    protected $model = ProductPriceTier::class;

    public function definition(): array
    {
        return [];
    }
}
