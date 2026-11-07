<?php

namespace App\Modules\Orders\Disputes\Database\Factories;

use App\Modules\Orders\Disputes\Models\DisputeResolution;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DisputeResolution>
 */
class DisputeResolutionFactory extends Factory
{
    protected $model = DisputeResolution::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
