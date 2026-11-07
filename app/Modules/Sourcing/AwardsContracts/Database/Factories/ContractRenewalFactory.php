<?php

namespace App\Modules\Sourcing\AwardsContracts\Database\Factories;

use App\Modules\Sourcing\AwardsContracts\Models\ContractRenewal;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContractRenewal>
 */
class ContractRenewalFactory extends Factory
{
    protected $model = ContractRenewal::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
