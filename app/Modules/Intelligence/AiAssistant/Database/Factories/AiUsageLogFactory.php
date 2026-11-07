<?php

namespace App\Modules\Intelligence\AiAssistant\Database\Factories;

use App\Models\Organization;
use App\Models\User;
use App\Modules\Intelligence\AiAssistant\Models\AiUsageLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AiUsageLog>
 */
class AiUsageLogFactory extends Factory
{
    protected $model = AiUsageLog::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'user_id' => User::factory(),
            'feature' => fake()->randomElement(['chat', 'draft_rfq', 'summarize_bids']),
            'provider' => 'fake',
            'model' => 'fake-model',
            'tokens_in' => fake()->numberBetween(10, 500),
            'tokens_out' => fake()->numberBetween(10, 800),
            'cost_usd' => fake()->randomFloat(6, 0, 0.05),
            'meta' => ['latency_ms' => fake()->randomFloat(2, 1, 400)],
        ];
    }
}
