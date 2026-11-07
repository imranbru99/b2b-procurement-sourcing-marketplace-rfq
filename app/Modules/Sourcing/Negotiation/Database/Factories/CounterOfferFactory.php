<?php

namespace App\Modules\Sourcing\Negotiation\Database\Factories;

use App\Modules\Sourcing\Negotiation\Models\CounterOffer;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CounterOffer>
 */
class CounterOfferFactory extends Factory
{
    protected $model = CounterOffer::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
