<?php

namespace App\Modules\Platform\SecurityCenter\Database\Factories;

use App\Modules\Platform\SecurityCenter\Models\UserSessionTracking;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<UserSessionTracking> */
class UserSessionTrackingFactory extends Factory
{
    protected $model = UserSessionTracking::class;

    public function definition(): array
    {
        return [
            'ip' => '127.0.0.1',
            'user_agent' => 'Pest',
            'last_activity_at' => now(),
        ];
    }
}
