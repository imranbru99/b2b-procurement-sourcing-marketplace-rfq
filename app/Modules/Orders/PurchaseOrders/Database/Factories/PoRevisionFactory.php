<?php

namespace App\Modules\Orders\PurchaseOrders\Database\Factories;

use App\Modules\Orders\PurchaseOrders\Models\PoRevision;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PoRevision>
 */
class PoRevisionFactory extends Factory
{
    protected $model = PoRevision::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
