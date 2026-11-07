<?php

namespace App\Modules\Orders\EscrowWallet\Database\Factories;

use App\Modules\Orders\EscrowWallet\Models\EscrowFee;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EscrowFee>
 */
class EscrowFeeFactory extends Factory
{
    protected $model = EscrowFee::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
