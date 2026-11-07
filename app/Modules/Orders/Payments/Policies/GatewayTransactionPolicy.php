<?php

namespace App\Modules\Orders\Payments\Policies;

use App\Models\User;
use App\Modules\Orders\Payments\Models\GatewayTransaction;
use App\Modules\Orders\Payments\Policies\Concerns\AuthorizesOrganizationEntity;

class GatewayTransactionPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, GatewayTransaction $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, GatewayTransaction $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, GatewayTransaction $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
