<?php

namespace App\Modules\Suppliers\Directory\Policies;

use App\Models\User;
use App\Modules\Suppliers\Directory\Models\SupplierCategory;

class SupplierCategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, SupplierCategory $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, SupplierCategory $record): bool
    {
        return true;
    }

    public function delete(User $user, SupplierCategory $record): bool
    {
        return true;
    }
}
