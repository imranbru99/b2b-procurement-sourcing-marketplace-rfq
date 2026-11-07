<?php

namespace App\Modules\Suppliers\Storefronts\Policies;

use App\Models\User;
use App\Modules\Suppliers\Storefronts\Models\SupplierStorefront;

class SupplierStorefrontPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, SupplierStorefront $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, SupplierStorefront $record): bool
    {
        return true;
    }

    public function delete(User $user, SupplierStorefront $record): bool
    {
        return true;
    }
}
