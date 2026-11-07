<?php

namespace App\Modules\Sourcing\PurchaseRequisitions\Database\Factories;

use App\Modules\Sourcing\PurchaseRequisitions\Models\ApprovalMatrixRule;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ApprovalMatrixRule>
 */
class ApprovalMatrixRuleFactory extends Factory
{
    protected $model = ApprovalMatrixRule::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
