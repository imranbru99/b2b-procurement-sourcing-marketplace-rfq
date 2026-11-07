<?php

namespace App\Modules\Intelligence\AnalyticsReporting\Policies;

use App\Models\User;
use App\Modules\Intelligence\AnalyticsReporting\Models\SavedReport;
use App\Modules\Operations\Budgets\Policies\Concerns\AuthorizesOrganizationEntity;

class SavedReportPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, SavedReport $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, SavedReport $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, SavedReport $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
