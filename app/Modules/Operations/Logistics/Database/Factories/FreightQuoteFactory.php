<?php

namespace App\Modules\Operations\Logistics\Database\Factories;

use App\Modules\Operations\Logistics\Models\FreightQuote;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FreightQuote>
 */
class FreightQuoteFactory extends Factory
{
    protected $model = FreightQuote::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
