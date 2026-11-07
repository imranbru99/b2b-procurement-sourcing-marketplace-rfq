<?php

namespace App\Modules\Orders\Payments\Database\Factories;

use App\Modules\Orders\Payments\Models\PaymentSchedule;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PaymentSchedule>
 */
class PaymentScheduleFactory extends Factory
{
    protected $model = PaymentSchedule::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
