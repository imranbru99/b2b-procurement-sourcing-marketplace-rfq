<?php

namespace App\Modules\Suppliers\KycOnboarding\Database\Factories;

use App\Modules\Suppliers\KycOnboarding\Models\KycDocument;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<KycDocument>
 */
class KycDocumentFactory extends Factory
{
    protected $model = KycDocument::class;

    public function definition(): array
    {
        return [];
    }
}
