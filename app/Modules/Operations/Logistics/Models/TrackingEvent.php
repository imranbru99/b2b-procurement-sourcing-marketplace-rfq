<?php

namespace App\Modules\Operations\Logistics\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Operations\Logistics\Database\Factories\TrackingEventFactory;

class TrackingEvent extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'tracking_events';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'occurred_at' => 'datetime',
);
    }

    protected static function newFactory(): TrackingEventFactory
    {
        return TrackingEventFactory::new();
    }
}
