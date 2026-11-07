<?php

namespace App\Modules\Sourcing\AwardsContracts\Database\Factories;

use App\Modules\Sourcing\AwardsContracts\Models\Contract;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contract>
 */
class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
