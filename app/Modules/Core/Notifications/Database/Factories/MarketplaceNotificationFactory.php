<?php

namespace App\Modules\Core\Notifications\Database\Factories;

use App\Models\Organization;
use App\Models\User;
use App\Modules\Core\Notifications\Models\MarketplaceNotification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MarketplaceNotification>
 */
class MarketplaceNotificationFactory extends Factory
{
    protected $model = MarketplaceNotification::class;

    public function definition(): array
    {
        return [
            'type' => 'info',
            'notifiable_type' => (new User)->getMorphClass(),
            'notifiable_id' => User::factory(),
            'organization_id' => Organization::factory(),
            'data' => [
                'title' => fake()->sentence(4),
                'body' => fake()->sentence(),
            ],
            'read_at' => null,
        ];
    }
}
