<?php

namespace App\Modules\Orders\EscrowWallet\Database\Factories;

use App\Modules\Orders\EscrowWallet\Models\EscrowMilestone;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EscrowMilestone>
 */
class EscrowMilestoneFactory extends Factory
{
    protected $model = EscrowMilestone::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
