<?php

namespace App\Modules\Orders\GoodsReceipt\Database\Factories;

use App\Modules\Orders\GoodsReceipt\Models\Grn;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Grn>
 */
class GrnFactory extends Factory
{
    protected $model = Grn::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'number' => 'GRN-'.fake()->unique()->numerify('######'),
            'status' => 'received',
            'received_at' => now(),
        ];
    }
}
