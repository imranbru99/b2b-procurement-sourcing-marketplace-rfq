<?php

namespace App\Modules\Core\Notifications\Policies;

use App\Models\User;
use App\Modules\Core\Notifications\Models\MarketplaceNotification;

class MarketplaceNotificationPolicy
{
    public function viewAny(?User $user): bool
    {
        return $this->allows($user);
    }

    public function view(?User $user, MarketplaceNotification $notification): bool
    {
        if (! $this->allows($user)) {
            return false;
        }

        if ($user?->is_platform_user) {
            return true;
        }

        return (int) $notification->notifiable_id === (int) $user?->id
            && $notification->notifiable_type === $user?->getMorphClass();
    }

    public function create(?User $user): bool
    {
        return $user?->is_platform_user === true && module_enabled('core.notifications');
    }

    public function update(?User $user, MarketplaceNotification $notification): bool
    {
        return $this->view($user, $notification);
    }

    public function delete(?User $user, MarketplaceNotification $notification): bool
    {
        return $user?->is_platform_user === true && $this->allows($user);
    }

    protected function allows(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        return module_enabled('core.notifications', $user->current_organization_id);
    }
}
