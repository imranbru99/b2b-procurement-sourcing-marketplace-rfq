<?php

namespace App\Modules\Orders\GoodsReceipt\Database\Factories;

use App\Modules\Orders\GoodsReceipt\Models\GrnItem;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GrnItem>
 */
class GrnItemFactory extends Factory
{
    protected $model = GrnItem::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
