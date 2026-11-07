<?php

namespace App\Modules\Platform\SubscriptionsBilling\Database\Factories;

use App\Modules\Platform\SubscriptionsBilling\Models\UsageLimit;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<UsageLimit> */
class UsageLimitFactory extends Factory
{
    protected $model = UsageLimit::class;

    public function definition(): array
    {
        return [
            'metric' => 'api_calls',
            'limit_value' => 10000,
            'current_value' => 0,
        ];
    }
}
