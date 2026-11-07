<?php

namespace App\Modules\Operations\Budgets\Database\Factories;

use App\Modules\Operations\Budgets\Models\BudgetAlert;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BudgetAlert>
 */
class BudgetAlertFactory extends Factory
{
    protected $model = BudgetAlert::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
