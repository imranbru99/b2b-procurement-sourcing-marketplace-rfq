<?php

namespace App\Modules\Suppliers\Directory\Database\Factories;

use App\Modules\Suppliers\Directory\Models\SupplierCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SupplierCategory>
 */
class SupplierCategoryFactory extends Factory
{
    protected $model = SupplierCategory::class;

    public function definition(): array
    {
        return [];
    }
}
