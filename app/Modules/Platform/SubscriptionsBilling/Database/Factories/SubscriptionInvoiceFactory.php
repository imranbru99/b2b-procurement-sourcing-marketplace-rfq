<?php

namespace App\Modules\Platform\SubscriptionsBilling\Database\Factories;

use App\Modules\Platform\SubscriptionsBilling\Models\SubscriptionInvoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SubscriptionInvoice> */
class SubscriptionInvoiceFactory extends Factory
{
    protected $model = SubscriptionInvoice::class;

    public function definition(): array
    {
        return [
            'number' => 'INV-'.fake()->unique()->numerify('######'),
            'amount' => 49.00,
            'status' => 'open',
        ];
    }
}
