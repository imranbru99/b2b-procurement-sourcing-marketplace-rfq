<?php

namespace App\Modules\Operations\InspectionAttendance\Database\Factories;

use App\Modules\Operations\InspectionAttendance\Models\InspectorAssignment;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InspectorAssignment>
 */
class InspectorAssignmentFactory extends Factory
{
    protected $model = InspectorAssignment::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
