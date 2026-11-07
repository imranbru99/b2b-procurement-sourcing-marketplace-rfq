<?php

namespace App\Modules\Operations\Budgets\Policies;

use App\Models\User;
use App\Modules\Operations\Budgets\Models\Budget;
use App\Modules\Operations\Budgets\Policies\Concerns\AuthorizesOrganizationEntity;

class BudgetPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Budget $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Budget $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, Budget $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
