<?php

namespace App\Modules\Sourcing\Negotiation\Database\Factories;

use App\Modules\Sourcing\Negotiation\Models\Negotiation;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Negotiation>
 */
class NegotiationFactory extends Factory
{
    protected $model = Negotiation::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
