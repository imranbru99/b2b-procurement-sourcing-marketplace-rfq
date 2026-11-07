<?php

namespace App\Modules\Suppliers\Directory\Database\Factories;

use App\Modules\Suppliers\Directory\Models\SupplierProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SupplierProfile>
 */
class SupplierProfileFactory extends Factory
{
    protected $model = SupplierProfile::class;

    public function definition(): array
    {
        return [
            'company_name' => fake()->company(),
            'tagline' => fake()->sentence(6),
            'description' => fake()->paragraph(),
            'country' => 'BD',
            'region' => 'Dhaka Division',
            'city' => 'Dhaka',
            'website' => fake()->url(),
            'moq' => fake()->numberBetween(1, 500),
            'capacity' => fake()->randomElement(['small', 'medium', 'large']),
            'business_type' => fake()->randomElement(['manufacturer', 'trader', 'distributor']),
            'employee_count' => fake()->numberBetween(5, 5000),
            'year_founded' => (int) fake()->year(),
        ];
    }
}
