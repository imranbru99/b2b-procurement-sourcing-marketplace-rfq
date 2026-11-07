<?php

namespace App\Modules\Core\Users\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(?User $user): bool
    {
        return $this->allows($user);
    }

    public function view(?User $user, User $model): bool
    {
        return $this->allows($user);
    }

    public function create(?User $user): bool
    {
        return $this->allows($user);
    }

    public function update(?User $user, User $model): bool
    {
        return $this->allows($user);
    }

    public function delete(?User $user, User $model): bool
    {
        return $user?->is_platform_user === true && module_enabled('core.users');
    }

    protected function allows(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        return module_enabled('core.users', $user->current_organization_id)
            && ($user->is_platform_user || $user->current_organization_id !== null);
    }
}
