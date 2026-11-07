<?php

namespace App\Modules\Suppliers\Storefronts\Database\Factories;

use App\Modules\Suppliers\Storefronts\Models\PortfolioItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PortfolioItem>
 */
class PortfolioItemFactory extends Factory
{
    protected $model = PortfolioItem::class;

    public function definition(): array
    {
        return [];
    }
}
