<?php

namespace App\Modules\Intelligence\AnalyticsReporting\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Intelligence\AnalyticsReporting\Database\Factories\ScheduledReportEmailFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduledReportEmail extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'scheduled_report_emails';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'last_sent_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function savedReport(): BelongsTo
    {
        return $this->belongsTo(SavedReport::class);
    }

    protected static function newFactory(): ScheduledReportEmailFactory
    {
        return ScheduledReportEmailFactory::new();
    }
}
