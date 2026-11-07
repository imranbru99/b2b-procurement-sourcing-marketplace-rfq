<?php

namespace App\Modules\Sourcing\Rfqs\Database\Factories;

use App\Modules\Sourcing\Rfqs\Models\RfqAnswer;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RfqAnswer>
 */
class RfqAnswerFactory extends Factory
{
    protected $model = RfqAnswer::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
