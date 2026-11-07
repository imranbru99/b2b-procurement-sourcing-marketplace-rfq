<?php

namespace App\Modules\Sourcing\ReverseAuctions\Database\Factories;

use App\Modules\Sourcing\ReverseAuctions\Models\AuctionBid;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AuctionBid>
 */
class AuctionBidFactory extends Factory
{
    protected $model = AuctionBid::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
