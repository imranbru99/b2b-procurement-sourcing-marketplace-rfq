<?php

namespace App\Modules\Suppliers\RiskCompliance\Database\Factories;

use App\Modules\Suppliers\RiskCompliance\Models\ApprovedVendorList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ApprovedVendorList>
 */
class ApprovedVendorListFactory extends Factory
{
    protected $model = ApprovedVendorList::class;

    public function definition(): array
    {
        return [];
    }
}
