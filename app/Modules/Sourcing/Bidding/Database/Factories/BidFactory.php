<?php

namespace App\Modules\Sourcing\Bidding\Database\Factories;

use App\Modules\Sourcing\Bidding\Models\Bid;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Bid>
 */
class BidFactory extends Factory
{
    protected $model = Bid::class;

    public function definition(): array
    {
        return [
            'organization_id' => \App\Models\Organization::factory(),
            'rfq_id' => \App\Modules\Sourcing\Rfqs\Models\Rfq::factory(),
            'supplier_organization_id' => \App\Models\Organization::factory()->state(['type' => 'supplier']),
            'status' => 'draft',
            'total' => fake()->randomFloat(2, 1000, 50000),
            'currency' => 'USD',
            'lead_time_days' => fake()->numberBetween(5, 60),
            'valid_until' => now()->addDays(30),
            'is_sealed' => true,
        ];
    }

    public function submitted(): static
    {
        return $this->state(fn () => [
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);
    }
}
