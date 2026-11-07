<?php

namespace App\Modules\Sourcing\Concerns;

use App\Models\User;

trait AuthorizesSourcingAccess
{
    protected function sourcingModuleEnabled(string $moduleKey, ?User $user = null): bool
    {
        $user ??= auth()->user();

        $organizationId = $user instanceof User ? $user->current_organization_id : organization_id();

        return module_enabled($moduleKey, $organizationId);
    }

    protected function userCan(?User $user, string $permission): bool
    {
        $user ??= auth()->user();

        if (! $user instanceof User) {
            return false;
        }

        return $user->can($permission);
    }
}
