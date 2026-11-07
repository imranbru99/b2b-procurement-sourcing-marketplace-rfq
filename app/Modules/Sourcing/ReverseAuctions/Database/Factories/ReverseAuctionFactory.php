<?php

namespace App\Modules\Sourcing\ReverseAuctions\Database\Factories;

use App\Modules\Sourcing\ReverseAuctions\Models\ReverseAuction;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReverseAuction>
 */
class ReverseAuctionFactory extends Factory
{
    protected $model = ReverseAuction::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
