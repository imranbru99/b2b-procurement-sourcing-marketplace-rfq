<?php

namespace App\Modules\Sourcing\BidScoring\Database\Factories;

use App\Modules\Sourcing\BidScoring\Models\ScoringCriterion;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ScoringCriterion>
 */
class ScoringCriterionFactory extends Factory
{
    protected $model = ScoringCriterion::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
