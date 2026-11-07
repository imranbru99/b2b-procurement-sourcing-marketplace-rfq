<?php

namespace App\Modules\Orders\GoodsReceipt\Database\Factories;

use App\Modules\Orders\GoodsReceipt\Models\QcInspection;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QcInspection>
 */
class QcInspectionFactory extends Factory
{
    protected $model = QcInspection::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
