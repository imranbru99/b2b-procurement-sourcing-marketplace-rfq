<?php

namespace App\Modules\Orders\EscrowWallet\Database\Factories;

use App\Modules\Orders\EscrowWallet\Models\EscrowWallet;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EscrowWallet>
 */
class EscrowWalletFactory extends Factory
{
    protected $model = EscrowWallet::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
