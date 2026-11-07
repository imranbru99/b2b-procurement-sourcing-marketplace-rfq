<?php

namespace App\Modules\Orders\Payments\Database\Factories;

use App\Modules\Orders\Payments\Models\Payment;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'reference' => 'PAY-'.fake()->unique()->numerify('######'),
            'status' => 'paid',
            'method' => 'bank_transfer',
            'currency' => 'USD',
            'amount' => 1150,
            'paid_at' => now(),
        ];
    }
}
