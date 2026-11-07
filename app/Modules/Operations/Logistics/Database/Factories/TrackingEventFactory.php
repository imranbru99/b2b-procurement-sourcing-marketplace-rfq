<?php

namespace App\Modules\Operations\Logistics\Database\Factories;

use App\Modules\Operations\Logistics\Models\TrackingEvent;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TrackingEvent>
 */
class TrackingEventFactory extends Factory
{
    protected $model = TrackingEvent::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
