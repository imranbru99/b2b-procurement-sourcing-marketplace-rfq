<?php

namespace App\Modules\Platform\ApiIntegrations\Database\Factories;

use App\Modules\Platform\ApiIntegrations\Models\ErpConnector;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<ErpConnector> */
class ErpConnectorFactory extends Factory
{
    protected $model = ErpConnector::class;

    public function definition(): array
    {
        return [
            'provider' => 'quickbooks',
            'credentials' => [],
            'is_active' => false,
        ];
    }
}
