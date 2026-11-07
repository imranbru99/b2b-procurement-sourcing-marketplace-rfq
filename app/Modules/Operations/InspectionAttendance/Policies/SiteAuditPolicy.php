<?php

namespace App\Modules\Operations\InspectionAttendance\Policies;

use App\Models\User;
use App\Modules\Operations\InspectionAttendance\Models\SiteAudit;
use App\Modules\Operations\InspectionAttendance\Policies\Concerns\AuthorizesOrganizationEntity;

class SiteAuditPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, SiteAudit $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, SiteAudit $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, SiteAudit $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
