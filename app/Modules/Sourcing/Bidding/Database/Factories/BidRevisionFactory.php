<?php

namespace App\Modules\Sourcing\Bidding\Database\Factories;

use App\Modules\Sourcing\Bidding\Models\BidRevision;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BidRevision>
 */
class BidRevisionFactory extends Factory
{
    protected $model = BidRevision::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
