<?php

namespace App\Modules\Operations\InspectionAttendance\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Operations\InspectionAttendance\Database\Factories\AuditChecklistFactory;

class AuditChecklist extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'audit_checklists';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'passed' => 'boolean',
);
    }

    protected static function newFactory(): AuditChecklistFactory
    {
        return AuditChecklistFactory::new();
    }
}
