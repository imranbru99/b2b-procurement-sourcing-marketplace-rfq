<?php

namespace App\Modules\Sourcing\BidScoring\Database\Factories;

use App\Modules\Sourcing\BidScoring\Models\BidEvaluatorAssignment;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BidEvaluatorAssignment>
 */
class BidEvaluatorAssignmentFactory extends Factory
{
    protected $model = BidEvaluatorAssignment::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
