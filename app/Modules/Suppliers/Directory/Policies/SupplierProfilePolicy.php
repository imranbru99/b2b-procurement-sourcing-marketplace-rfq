<?php

namespace App\Modules\Suppliers\Directory\Policies;

use App\Models\User;
use App\Modules\Suppliers\Directory\Models\SupplierProfile;

class SupplierProfilePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, SupplierProfile $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, SupplierProfile $record): bool
    {
        return true;
    }

    public function delete(User $user, SupplierProfile $record): bool
    {
        return true;
    }
}
