<?php

namespace App\Modules\Operations\InventoryLite\Database\Factories;

use App\Modules\Operations\InventoryLite\Models\ReorderPoint;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReorderPoint>
 */
class ReorderPointFactory extends Factory
{
    protected $model = ReorderPoint::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
