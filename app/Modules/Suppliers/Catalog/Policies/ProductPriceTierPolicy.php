<?php

namespace App\Modules\Suppliers\Catalog\Policies;

use App\Models\User;
use App\Modules\Suppliers\Catalog\Models\ProductPriceTier;

class ProductPriceTierPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ProductPriceTier $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ProductPriceTier $record): bool
    {
        return true;
    }

    public function delete(User $user, ProductPriceTier $record): bool
    {
        return true;
    }
}
