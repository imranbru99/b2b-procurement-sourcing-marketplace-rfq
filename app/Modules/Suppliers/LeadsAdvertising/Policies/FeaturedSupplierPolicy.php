<?php

namespace App\Modules\Suppliers\LeadsAdvertising\Policies;

use App\Models\User;
use App\Modules\Suppliers\LeadsAdvertising\Models\FeaturedSupplier;

class FeaturedSupplierPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, FeaturedSupplier $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, FeaturedSupplier $record): bool
    {
        return true;
    }

    public function delete(User $user, FeaturedSupplier $record): bool
    {
        return true;
    }
}
