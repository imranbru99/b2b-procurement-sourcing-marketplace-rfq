<?php

namespace App\Modules\Orders\PurchaseOrders\Database\Factories;

use App\Modules\Orders\PurchaseOrders\Models\PoAcknowledgment;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PoAcknowledgment>
 */
class PoAcknowledgmentFactory extends Factory
{
    protected $model = PoAcknowledgment::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
