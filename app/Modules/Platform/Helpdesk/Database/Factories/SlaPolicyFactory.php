<?php

namespace App\Modules\Platform\Helpdesk\Database\Factories;

use App\Modules\Platform\Helpdesk\Models\SlaPolicy;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SlaPolicy> */
class SlaPolicyFactory extends Factory
{
    protected $model = SlaPolicy::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'first_response_minutes' => 60,
            'resolution_minutes' => 1440,
        ];
    }
}
