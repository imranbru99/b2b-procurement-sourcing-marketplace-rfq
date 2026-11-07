<?php

namespace App\Modules\Suppliers\KycOnboarding\Policies;

use App\Models\User;
use App\Modules\Suppliers\KycOnboarding\Models\SupplierBlacklist;

class SupplierBlacklistPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, SupplierBlacklist $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, SupplierBlacklist $record): bool
    {
        return true;
    }

    public function delete(User $user, SupplierBlacklist $record): bool
    {
        return true;
    }
}
