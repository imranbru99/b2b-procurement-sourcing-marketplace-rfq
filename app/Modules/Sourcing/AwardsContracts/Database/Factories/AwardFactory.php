<?php

namespace App\Modules\Sourcing\AwardsContracts\Database\Factories;

use App\Modules\Sourcing\AwardsContracts\Models\Award;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Award>
 */
class AwardFactory extends Factory
{
    protected $model = Award::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
