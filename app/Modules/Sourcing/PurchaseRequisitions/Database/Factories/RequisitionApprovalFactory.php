<?php

namespace App\Modules\Sourcing\PurchaseRequisitions\Database\Factories;

use App\Modules\Sourcing\PurchaseRequisitions\Models\RequisitionApproval;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RequisitionApproval>
 */
class RequisitionApprovalFactory extends Factory
{
    protected $model = RequisitionApproval::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
