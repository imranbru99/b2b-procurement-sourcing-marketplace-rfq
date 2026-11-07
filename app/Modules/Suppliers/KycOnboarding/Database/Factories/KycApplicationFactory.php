<?php

namespace App\Modules\Suppliers\KycOnboarding\Database\Factories;

use App\Modules\Suppliers\KycOnboarding\Models\KycApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<KycApplication>
 */
class KycApplicationFactory extends Factory
{
    protected $model = KycApplication::class;

    public function definition(): array
    {
        return [];
    }
}
