<?php

namespace App\Modules\Platform\SecurityCenter\Database\Factories;

use App\Modules\Platform\SecurityCenter\Models\GdprRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<GdprRequest> */
class GdprRequestFactory extends Factory
{
    protected $model = GdprRequest::class;

    public function definition(): array
    {
        return [
            'type' => 'export',
            'status' => 'pending',
            'payload' => [],
        ];
    }
}
