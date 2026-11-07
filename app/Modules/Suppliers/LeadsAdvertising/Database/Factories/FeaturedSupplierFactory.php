<?php

namespace App\Modules\Suppliers\LeadsAdvertising\Database\Factories;

use App\Modules\Suppliers\LeadsAdvertising\Models\FeaturedSupplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FeaturedSupplier>
 */
class FeaturedSupplierFactory extends Factory
{
    protected $model = FeaturedSupplier::class;

    public function definition(): array
    {
        return [];
    }
}
