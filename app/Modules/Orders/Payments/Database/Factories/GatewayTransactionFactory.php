<?php

namespace App\Modules\Orders\Payments\Database\Factories;

use App\Modules\Orders\Payments\Models\GatewayTransaction;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GatewayTransaction>
 */
class GatewayTransactionFactory extends Factory
{
    protected $model = GatewayTransaction::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
