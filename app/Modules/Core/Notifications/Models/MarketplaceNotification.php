<?php

namespace App\Modules\Core\Notifications\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Core\Notifications\Database\Factories\MarketplaceNotificationFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MarketplaceNotification extends Model
{
    /** @use HasFactory<MarketplaceNotificationFactory> */
    use BelongsToOrganization;
    use HasFactory;
    use HasUuids;

    protected $table = 'marketplace_notifications';

    protected $fillable = [
        'type',
        'notifiable_type',
        'notifiable_id',
        'organization_id',
        'data',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'read_at' => 'datetime',
        ];
    }

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    public function markAsRead(): void
    {
        if ($this->read_at === null) {
            $this->forceFill(['read_at' => now()])->save();
        }
    }

    protected static function newFactory(): MarketplaceNotificationFactory
    {
        return MarketplaceNotificationFactory::new();
    }
}
