<?php

namespace App\Modules\Operations\InventoryLite\Policies;

use App\Models\User;
use App\Modules\Operations\InventoryLite\Models\InventoryItem;
use App\Modules\Operations\InventoryLite\Policies\Concerns\AuthorizesOrganizationEntity;

class InventoryItemPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, InventoryItem $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, InventoryItem $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, InventoryItem $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
