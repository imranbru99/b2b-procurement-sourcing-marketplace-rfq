<?php

namespace App\Modules\Suppliers\KycOnboarding\Database\Factories;

use App\Modules\Suppliers\KycOnboarding\Models\SupplierBlacklist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SupplierBlacklist>
 */
class SupplierBlacklistFactory extends Factory
{
    protected $model = SupplierBlacklist::class;

    public function definition(): array
    {
        return [];
    }
}
