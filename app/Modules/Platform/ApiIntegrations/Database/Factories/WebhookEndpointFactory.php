<?php

namespace App\Modules\Platform\ApiIntegrations\Database\Factories;

use App\Modules\Platform\ApiIntegrations\Models\WebhookEndpoint;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<WebhookEndpoint> */
class WebhookEndpointFactory extends Factory
{
    protected $model = WebhookEndpoint::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'url' => fake()->url(),
            'events' => ['rfq.created'],
            'is_active' => true,
        ];
    }
}
