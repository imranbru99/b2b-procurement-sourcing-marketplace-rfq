<?php

namespace App\Modules\Orders\EscrowWallet\Policies;

use App\Models\User;
use App\Modules\Orders\EscrowWallet\Models\WalletTransaction;
use App\Modules\Orders\EscrowWallet\Policies\Concerns\AuthorizesOrganizationEntity;

class WalletTransactionPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, WalletTransaction $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, WalletTransaction $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, WalletTransaction $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
