<?php

namespace App\Modules\Orders\EscrowWallet\Policies;

use App\Models\User;
use App\Modules\Orders\EscrowWallet\Models\EscrowWallet;
use App\Modules\Orders\EscrowWallet\Policies\Concerns\AuthorizesOrganizationEntity;

class EscrowWalletPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, EscrowWallet $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, EscrowWallet $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, EscrowWallet $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
