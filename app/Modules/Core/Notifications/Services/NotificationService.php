<?php

namespace App\Modules\Core\Notifications\Services;

use App\Modules\Core\Notifications\Models\MarketplaceNotification;
use Illuminate\Database\Eloquent\Model;

class NotificationService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function notify(Model $notifiable, string $type, array $data = [], ?int $organizationId = null): MarketplaceNotification
    {
        return MarketplaceNotification::query()->create([
            'type' => $type,
            'notifiable_type' => $notifiable->getMorphClass(),
            'notifiable_id' => $notifiable->getKey(),
            'organization_id' => $organizationId ?? organization_id(),
            'data' => $data,
        ]);
    }

    public function markAsRead(MarketplaceNotification $notification): void
    {
        $notification->markAsRead();
    }

    public function markAllAsRead(Model $notifiable): int
    {
        return MarketplaceNotification::query()
            ->withoutGlobalScopes()
            ->where('notifiable_type', $notifiable->getMorphClass())
            ->where('notifiable_id', $notifiable->getKey())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }
}
