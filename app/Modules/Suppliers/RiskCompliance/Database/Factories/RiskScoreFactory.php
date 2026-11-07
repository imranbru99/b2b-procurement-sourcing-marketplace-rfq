<?php

namespace App\Modules\Suppliers\RiskCompliance\Database\Factories;

use App\Modules\Suppliers\RiskCompliance\Models\RiskScore;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RiskScore>
 */
class RiskScoreFactory extends Factory
{
    protected $model = RiskScore::class;

    public function definition(): array
    {
        return [];
    }
}
