<?php

namespace App\Modules\Suppliers\Storefronts\Database\Factories;

use App\Modules\Suppliers\Storefronts\Models\SupplierFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SupplierFactory>
 */
class SupplierFactoryFactory extends Factory
{
    protected $model = SupplierFactory::class;

    public function definition(): array
    {
        return [];
    }
}
