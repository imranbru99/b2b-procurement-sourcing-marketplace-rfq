<?php

namespace App\Modules\Platform\SubscriptionsBilling\Database\Factories;

use App\Modules\Platform\SubscriptionsBilling\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Subscription> */
class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        return [
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => now()->addYear(),
        ];
    }
}
