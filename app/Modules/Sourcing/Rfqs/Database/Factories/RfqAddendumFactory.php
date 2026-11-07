<?php

namespace App\Modules\Sourcing\Rfqs\Database\Factories;

use App\Modules\Sourcing\Rfqs\Models\RfqAddendum;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RfqAddendum>
 */
class RfqAddendumFactory extends Factory
{
    protected $model = RfqAddendum::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
