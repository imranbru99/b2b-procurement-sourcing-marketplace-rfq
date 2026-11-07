<?php

namespace App\Modules\Core\Settings\Policies;

use App\Models\User;
use App\Modules\Core\Settings\Models\Setting;

class SettingPolicy
{
    public function viewAny(?User $user): bool
    {
        return $this->allows($user);
    }

    public function view(?User $user, Setting $setting): bool
    {
        return $this->allows($user) && $this->sameOrganization($user, $setting);
    }

    public function create(?User $user): bool
    {
        return $this->allows($user);
    }

    public function update(?User $user, Setting $setting): bool
    {
        if (! $this->allows($user) || ! $this->sameOrganization($user, $setting)) {
            return false;
        }

        return ! $setting->is_locked || ($user?->is_platform_user ?? false);
    }

    public function delete(?User $user, Setting $setting): bool
    {
        return $this->update($user, $setting);
    }

    protected function allows(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        return module_enabled('core.settings', $user->current_organization_id)
            && ($user->is_platform_user || $user->current_organization_id !== null);
    }

    protected function sameOrganization(?User $user, Setting $setting): bool
    {
        if ($user === null) {
            return false;
        }

        if ($user->is_platform_user) {
            return true;
        }

        if ($setting->organization_id === null) {
            return false;
        }

        return (int) $setting->organization_id === (int) $user->current_organization_id;
    }
}
