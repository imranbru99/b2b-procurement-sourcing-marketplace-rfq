<?php

namespace App\Modules\Operations\InspectionAttendance\Policies;

use App\Models\User;
use App\Modules\Operations\InspectionAttendance\Models\AuditChecklist;
use App\Modules\Operations\InspectionAttendance\Policies\Concerns\AuthorizesOrganizationEntity;

class AuditChecklistPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, AuditChecklist $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, AuditChecklist $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, AuditChecklist $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
