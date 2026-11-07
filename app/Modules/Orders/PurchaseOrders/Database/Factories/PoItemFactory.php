<?php

namespace App\Modules\Orders\PurchaseOrders\Database\Factories;

use App\Modules\Orders\PurchaseOrders\Models\PoItem;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PoItem>
 */
class PoItemFactory extends Factory
{
    protected $model = PoItem::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
