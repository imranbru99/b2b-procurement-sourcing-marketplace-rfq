<?php

namespace App\Modules\Suppliers\RiskCompliance\Database\Factories;

use App\Modules\Suppliers\RiskCompliance\Models\ComplianceDocument;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ComplianceDocument>
 */
class ComplianceDocumentFactory extends Factory
{
    protected $model = ComplianceDocument::class;

    public function definition(): array
    {
        return [];
    }
}
