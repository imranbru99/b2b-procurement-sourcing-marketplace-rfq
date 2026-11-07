<?php

namespace App\Modules\Sourcing\Negotiation\Database\Factories;

use App\Modules\Sourcing\Negotiation\Models\NegotiationMessage;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NegotiationMessage>
 */
class NegotiationMessageFactory extends Factory
{
    protected $model = NegotiationMessage::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
