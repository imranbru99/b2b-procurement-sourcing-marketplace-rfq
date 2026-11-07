<?php

namespace App\Modules\Sourcing\SupplierInvitations\Database\Factories;

use App\Modules\Sourcing\SupplierInvitations\Models\SupplierBroadcastProfile;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SupplierBroadcastProfile>
 */
class SupplierBroadcastProfileFactory extends Factory
{
    protected $model = SupplierBroadcastProfile::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
