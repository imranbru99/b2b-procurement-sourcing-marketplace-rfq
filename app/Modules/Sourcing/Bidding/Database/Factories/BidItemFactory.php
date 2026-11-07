<?php

namespace App\Modules\Sourcing\Bidding\Database\Factories;

use App\Modules\Sourcing\Bidding\Models\BidItem;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BidItem>
 */
class BidItemFactory extends Factory
{
    protected $model = BidItem::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
