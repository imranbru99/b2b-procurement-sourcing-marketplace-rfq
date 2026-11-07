<?php

namespace App\Modules\Intelligence\MarketDataCatalog\Database\Factories;

use App\Models\Organization;
use App\Modules\Intelligence\MarketDataCatalog\Models\ScrapedCatalogItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ScrapedCatalogItem>
 */
class ScrapedCatalogItemFactory extends Factory
{
    protected $model = ScrapedCatalogItem::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'source_url' => fake()->url(),
            'title' => fake()->words(4, true),
            'price' => fake()->randomFloat(4, 1, 500),
            'currency' => 'USD',
            'status' => 'pending',
            'raw' => ['source' => 'factory'],
        ];
    }
}
