<?php

namespace App\Modules\Operations\Logistics\Database\Factories;

use App\Modules\Operations\Logistics\Models\DeliveryProof;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DeliveryProof>
 */
class DeliveryProofFactory extends Factory
{
    protected $model = DeliveryProof::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
