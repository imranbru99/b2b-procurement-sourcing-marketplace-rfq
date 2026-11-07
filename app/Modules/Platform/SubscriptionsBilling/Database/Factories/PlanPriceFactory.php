<?php

namespace App\Modules\Platform\SubscriptionsBilling\Database\Factories;

use App\Modules\Platform\SubscriptionsBilling\Models\PlanPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<PlanPrice> */
class PlanPriceFactory extends Factory
{
    protected $model = PlanPrice::class;

    public function definition(): array
    {
        return [
            'currency' => 'USD',
            'amount' => 49.00,
            'interval' => 'month',
        ];
    }
}
