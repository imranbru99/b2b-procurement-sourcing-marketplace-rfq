<?php

namespace App\Modules\Intelligence\MarketDataCatalog\Database\Factories;

use App\Models\Organization;
use App\Modules\Intelligence\MarketDataCatalog\Models\PriceBenchmark;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PriceBenchmark>
 */
class PriceBenchmarkFactory extends Factory
{
    protected $model = PriceBenchmark::class;

    public function definition(): array
    {
        $median = fake()->randomFloat(4, 10, 500);

        return [
            'organization_id' => Organization::factory(),
            'category' => fake()->randomElement(['steel', 'textiles', 'electronics']),
            'sku' => strtoupper(fake()->bothify('SKU-####')),
            'title' => fake()->words(3, true),
            'median_price' => $median,
            'p25_price' => $median * 0.85,
            'p75_price' => $median * 1.15,
            'currency' => 'USD',
            'sample_size' => fake()->numberBetween(5, 100),
            'meta' => [],
        ];
    }
}
