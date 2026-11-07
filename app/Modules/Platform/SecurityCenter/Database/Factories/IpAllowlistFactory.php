<?php

namespace App\Modules\Platform\SecurityCenter\Database\Factories;

use App\Modules\Platform\SecurityCenter\Models\IpAllowlist;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<IpAllowlist> */
class IpAllowlistFactory extends Factory
{
    protected $model = IpAllowlist::class;

    public function definition(): array
    {
        return [
            'cidr' => '192.168.0.0/24',
            'label' => 'Office',
            'is_active' => true,
        ];
    }
}
