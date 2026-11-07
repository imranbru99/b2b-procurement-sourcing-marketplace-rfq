<?php

namespace App\Modules\Operations\Budgets\Policies;

use App\Models\User;
use App\Modules\Operations\Budgets\Models\BudgetAlert;
use App\Modules\Operations\Budgets\Policies\Concerns\AuthorizesOrganizationEntity;

class BudgetAlertPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, BudgetAlert $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, BudgetAlert $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, BudgetAlert $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
