<?php

namespace App\Modules\Core\Organizations\Policies;

use App\Models\Organization;
use App\Models\User;

class OrganizationPolicy
{
    public function viewAny(?User $user): bool
    {
        return $this->allows($user);
    }

    public function view(?User $user, Organization $organization): bool
    {
        return $this->allows($user) && $this->canAccessOrganization($user, $organization);
    }

    public function create(?User $user): bool
    {
        return $user?->is_platform_user === true && module_enabled('core.organizations');
    }

    public function update(?User $user, Organization $organization): bool
    {
        return $this->allows($user) && $this->canAccessOrganization($user, $organization);
    }

    public function delete(?User $user, Organization $organization): bool
    {
        return $user?->is_platform_user === true && module_enabled('core.organizations');
    }

    protected function allows(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        return module_enabled('core.organizations', $user->current_organization_id);
    }

    protected function canAccessOrganization(?User $user, Organization $organization): bool
    {
        if ($user === null) {
            return false;
        }

        if ($user->is_platform_user) {
            return true;
        }

        return $user->organizations()->where('organizations.id', $organization->id)->exists();
    }
}
