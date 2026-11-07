<?php

namespace App\Modules\Platform\ApiIntegrations\Database\Factories;

use App\Modules\Platform\ApiIntegrations\Models\WebhookDelivery;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<WebhookDelivery> */
class WebhookDeliveryFactory extends Factory
{
    protected $model = WebhookDelivery::class;

    public function definition(): array
    {
        return [
            'event' => 'rfq.created',
            'payload' => ['id' => 1],
            'status' => 'delivered',
            'response_code' => 200,
        ];
    }
}
