<?php

namespace App\Modules\Orders\PurchaseOrders\Policies;

use App\Models\User;
use App\Modules\Orders\PurchaseOrders\Models\PoRevision;
use App\Modules\Orders\PurchaseOrders\Policies\Concerns\AuthorizesOrganizationEntity;

class PoRevisionPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, PoRevision $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, PoRevision $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, PoRevision $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
