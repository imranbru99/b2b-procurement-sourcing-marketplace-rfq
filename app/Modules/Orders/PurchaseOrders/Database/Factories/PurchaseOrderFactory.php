<?php

namespace App\Modules\Orders\PurchaseOrders\Database\Factories;

use App\Modules\Orders\PurchaseOrders\Models\PurchaseOrder;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PurchaseOrder>
 */
class PurchaseOrderFactory extends Factory
{
    protected $model = PurchaseOrder::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'number' => 'PO-'.fake()->unique()->numerify('######'),
            'status' => 'issued',
            'currency' => 'USD',
            'subtotal' => 1000,
            'tax_total' => 150,
            'total' => 1150,
            'issued_at' => now(),
        ];
    }
}
