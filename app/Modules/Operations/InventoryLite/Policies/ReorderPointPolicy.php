<?php

namespace App\Modules\Operations\InventoryLite\Policies;

use App\Models\User;
use App\Modules\Operations\InventoryLite\Models\ReorderPoint;
use App\Modules\Operations\InventoryLite\Policies\Concerns\AuthorizesOrganizationEntity;

class ReorderPointPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ReorderPoint $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ReorderPoint $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, ReorderPoint $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
