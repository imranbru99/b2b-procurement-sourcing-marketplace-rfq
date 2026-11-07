<?php

namespace App\Modules\Orders\Invoicing\Database\Factories;

use App\Modules\Orders\Invoicing\Models\Invoice;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'number' => 'INV-'.fake()->unique()->numerify('######'),
            'status' => 'approved',
            'currency' => 'USD',
            'subtotal' => 1000,
            'tax_type' => 'VAT',
            'tax_rate' => 15,
            'tax_total' => 150,
            'total' => 1150,
            'issued_at' => now(),
        ];
    }
}
