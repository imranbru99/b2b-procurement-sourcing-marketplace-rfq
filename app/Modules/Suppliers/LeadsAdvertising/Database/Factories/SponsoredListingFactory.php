<?php

namespace App\Modules\Suppliers\LeadsAdvertising\Database\Factories;

use App\Modules\Suppliers\LeadsAdvertising\Models\SponsoredListing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SponsoredListing>
 */
class SponsoredListingFactory extends Factory
{
    protected $model = SponsoredListing::class;

    public function definition(): array
    {
        return [];
    }
}
