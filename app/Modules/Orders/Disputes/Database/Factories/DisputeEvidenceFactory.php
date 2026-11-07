<?php

namespace App\Modules\Orders\Disputes\Database\Factories;

use App\Modules\Orders\Disputes\Models\DisputeEvidence;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DisputeEvidence>
 */
class DisputeEvidenceFactory extends Factory
{
    protected $model = DisputeEvidence::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
