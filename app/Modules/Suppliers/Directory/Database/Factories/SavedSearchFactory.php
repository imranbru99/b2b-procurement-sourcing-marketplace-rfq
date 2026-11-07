<?php

namespace App\Modules\Suppliers\Directory\Database\Factories;

use App\Modules\Suppliers\Directory\Models\SavedSearch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SavedSearch>
 */
class SavedSearchFactory extends Factory
{
    protected $model = SavedSearch::class;

    public function definition(): array
    {
        return [];
    }
}
