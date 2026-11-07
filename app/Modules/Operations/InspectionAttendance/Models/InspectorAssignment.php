<?php

namespace App\Modules\Operations\InspectionAttendance\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Operations\InspectionAttendance\Database\Factories\InspectorAssignmentFactory;

class InspectorAssignment extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'inspector_assignments';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'starts_at' => 'datetime',
  'ends_at' => 'datetime',
);
    }

    protected static function newFactory(): InspectorAssignmentFactory
    {
        return InspectorAssignmentFactory::new();
    }
}
