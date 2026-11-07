<?php

namespace App\Modules\Suppliers\Catalog\Database\Factories;

use App\Modules\Suppliers\Catalog\Models\ProductSpecialPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductSpecialPrice>
 */
class ProductSpecialPriceFactory extends Factory
{
    protected $model = ProductSpecialPrice::class;

    public function definition(): array
    {
        return [];
    }
}
