<?php

namespace App\Modules\Operations\Logistics\Database\Factories;

use App\Modules\Operations\Logistics\Models\Carrier;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Carrier>
 */
class CarrierFactory extends Factory
{
    protected $model = Carrier::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
