<?php

namespace App\Modules\Orders\GoodsReceipt\Database\Factories;

use App\Modules\Orders\GoodsReceipt\Models\GoodsReturn;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GoodsReturn>
 */
class GoodsReturnFactory extends Factory
{
    protected $model = GoodsReturn::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
