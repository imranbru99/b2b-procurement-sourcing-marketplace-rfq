<?php

namespace App\Modules\Sourcing\PurchaseRequisitions\Database\Factories;

use App\Modules\Sourcing\PurchaseRequisitions\Models\PurchaseRequisition;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PurchaseRequisition>
 */
class PurchaseRequisitionFactory extends Factory
{
    protected $model = PurchaseRequisition::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
