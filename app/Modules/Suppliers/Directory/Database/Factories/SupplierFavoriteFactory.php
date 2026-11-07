<?php

namespace App\Modules\Suppliers\Directory\Database\Factories;

use App\Modules\Suppliers\Directory\Models\SupplierFavorite;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SupplierFavorite>
 */
class SupplierFavoriteFactory extends Factory
{
    protected $model = SupplierFavorite::class;

    public function definition(): array
    {
        return [];
    }
}
