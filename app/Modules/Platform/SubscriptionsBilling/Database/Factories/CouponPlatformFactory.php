<?php

namespace App\Modules\Platform\SubscriptionsBilling\Database\Factories;

use App\Modules\Platform\SubscriptionsBilling\Models\CouponPlatform;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<CouponPlatform> */
class CouponPlatformFactory extends Factory
{
    protected $model = CouponPlatform::class;

    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->bothify('SAVE##??')),
            'discount_percent' => 10,
            'max_uses' => 100,
        ];
    }
}
