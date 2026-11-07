<?php

namespace App\Modules\Operations\InventoryLite\Database\Factories;

use App\Modules\Operations\InventoryLite\Models\StockLevel;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StockLevel>
 */
class StockLevelFactory extends Factory
{
    protected $model = StockLevel::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
