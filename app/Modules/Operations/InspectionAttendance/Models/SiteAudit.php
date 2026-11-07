<?php

namespace App\Modules\Operations\InspectionAttendance\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Operations\InspectionAttendance\Database\Factories\SiteAuditFactory;

class SiteAudit extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'site_audits';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'audited_at' => 'datetime',
);
    }

    protected static function newFactory(): SiteAuditFactory
    {
        return SiteAuditFactory::new();
    }
}
