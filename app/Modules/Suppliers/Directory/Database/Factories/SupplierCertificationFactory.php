<?php

namespace App\Modules\Suppliers\Directory\Database\Factories;

use App\Modules\Suppliers\Directory\Models\SupplierCertification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SupplierCertification>
 */
class SupplierCertificationFactory extends Factory
{
    protected $model = SupplierCertification::class;

    public function definition(): array
    {
        return [];
    }
}
