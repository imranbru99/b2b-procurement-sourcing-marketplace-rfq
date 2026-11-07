<?php

namespace App\Modules\Operations\InspectionAttendance\Database\Factories;

use App\Modules\Operations\InspectionAttendance\Models\SiteAudit;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SiteAudit>
 */
class SiteAuditFactory extends Factory
{
    protected $model = SiteAudit::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
