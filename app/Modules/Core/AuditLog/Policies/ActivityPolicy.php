<?php

namespace App\Modules\Core\AuditLog\Policies;

use App\Models\User;
use Spatie\Activitylog\Models\Activity;

class ActivityPolicy
{
    public function viewAny(?User $user): bool
    {
        return $this->allows($user);
    }

    public function view(?User $user, Activity $activity): bool
    {
        return $this->allows($user);
    }

    public function create(?User $user): bool
    {
        return false;
    }

    public function update(?User $user, Activity $activity): bool
    {
        return false;
    }

    public function delete(?User $user, Activity $activity): bool
    {
        return false;
    }

    protected function allows(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        return module_enabled('core.audit-log', $user->current_organization_id)
            && ($user->is_platform_user || $user->current_organization_id !== null);
    }
}
