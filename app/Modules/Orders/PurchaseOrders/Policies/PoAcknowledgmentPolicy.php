<?php

namespace App\Modules\Orders\PurchaseOrders\Policies;

use App\Models\User;
use App\Modules\Orders\PurchaseOrders\Models\PoAcknowledgment;
use App\Modules\Orders\PurchaseOrders\Policies\Concerns\AuthorizesOrganizationEntity;

class PoAcknowledgmentPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, PoAcknowledgment $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, PoAcknowledgment $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, PoAcknowledgment $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
