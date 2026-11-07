<?php

namespace App\Modules\Operations\InspectionAttendance\Database\Factories;

use App\Modules\Operations\InspectionAttendance\Models\AuditChecklist;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AuditChecklist>
 */
class AuditChecklistFactory extends Factory
{
    protected $model = AuditChecklist::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
