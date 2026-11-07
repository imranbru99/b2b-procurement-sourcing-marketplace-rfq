<?php

namespace App\Modules\Platform\ApiIntegrations\Database\Factories;

use App\Modules\Platform\ApiIntegrations\Models\ApiLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<ApiLog> */
class ApiLogFactory extends Factory
{
    protected $model = ApiLog::class;

    public function definition(): array
    {
        return [
            'method' => 'GET',
            'path' => '/api/v1/rfqs',
            'status_code' => 200,
            'duration_ms' => 12,
        ];
    }
}
