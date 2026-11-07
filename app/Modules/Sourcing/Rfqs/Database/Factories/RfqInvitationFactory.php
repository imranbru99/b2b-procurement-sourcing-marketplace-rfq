<?php

namespace App\Modules\Sourcing\Rfqs\Database\Factories;

use App\Modules\Sourcing\Rfqs\Models\RfqInvitation;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RfqInvitation>
 */
class RfqInvitationFactory extends Factory
{
    protected $model = RfqInvitation::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
