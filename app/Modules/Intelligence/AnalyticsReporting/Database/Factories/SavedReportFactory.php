<?php

namespace App\Modules\Intelligence\AnalyticsReporting\Database\Factories;

use App\Models\Organization;
use App\Models\User;
use App\Modules\Intelligence\AnalyticsReporting\Models\SavedReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SavedReport>
 */
class SavedReportFactory extends Factory
{
    protected $model = SavedReport::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'created_by' => User::factory(),
            'name' => fake()->sentence(3),
            'type' => fake()->randomElement(['spend', 'savings', 'cycle_time']),
            'filters' => ['range' => '90d'],
            'layout' => ['widgets' => ['spend_by_supplier']],
        ];
    }
}
