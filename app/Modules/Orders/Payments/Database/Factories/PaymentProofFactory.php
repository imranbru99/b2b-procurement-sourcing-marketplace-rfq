<?php

namespace App\Modules\Orders\Payments\Database\Factories;

use App\Modules\Orders\Payments\Models\PaymentProof;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PaymentProof>
 */
class PaymentProofFactory extends Factory
{
    protected $model = PaymentProof::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
