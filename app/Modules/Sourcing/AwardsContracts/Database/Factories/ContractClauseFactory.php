<?php

namespace App\Modules\Sourcing\AwardsContracts\Database\Factories;

use App\Modules\Sourcing\AwardsContracts\Models\ContractClause;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContractClause>
 */
class ContractClauseFactory extends Factory
{
    protected $model = ContractClause::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
