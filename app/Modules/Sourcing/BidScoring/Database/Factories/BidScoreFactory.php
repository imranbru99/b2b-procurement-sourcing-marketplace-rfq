<?php

namespace App\Modules\Sourcing\BidScoring\Database\Factories;

use App\Modules\Sourcing\BidScoring\Models\BidScore;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BidScore>
 */
class BidScoreFactory extends Factory
{
    protected $model = BidScore::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
