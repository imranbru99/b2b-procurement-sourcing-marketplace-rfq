<?php

namespace App\Modules\Intelligence\AnalyticsReporting\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\User;
use App\Modules\Intelligence\AnalyticsReporting\Database\Factories\SavedReportFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SavedReport extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'saved_reports';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'filters' => 'array',
            'layout' => 'array',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scheduledEmails(): HasMany
    {
        return $this->hasMany(ScheduledReportEmail::class);
    }

    protected static function newFactory(): SavedReportFactory
    {
        return SavedReportFactory::new();
    }
}
