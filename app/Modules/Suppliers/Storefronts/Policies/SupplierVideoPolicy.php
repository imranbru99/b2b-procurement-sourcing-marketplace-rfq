<?php

namespace App\Modules\Suppliers\Storefronts\Policies;

use App\Models\User;
use App\Modules\Suppliers\Storefronts\Models\SupplierVideo;

class SupplierVideoPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, SupplierVideo $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, SupplierVideo $record): bool
    {
        return true;
    }

    public function delete(User $user, SupplierVideo $record): bool
    {
        return true;
    }
}
