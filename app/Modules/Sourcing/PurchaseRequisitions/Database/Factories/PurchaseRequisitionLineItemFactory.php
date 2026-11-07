<?php

namespace App\Modules\Sourcing\PurchaseRequisitions\Database\Factories;

use App\Modules\Sourcing\PurchaseRequisitions\Models\PurchaseRequisitionLineItem;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PurchaseRequisitionLineItem>
 */
class PurchaseRequisitionLineItemFactory extends Factory
{
    protected $model = PurchaseRequisitionLineItem::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
