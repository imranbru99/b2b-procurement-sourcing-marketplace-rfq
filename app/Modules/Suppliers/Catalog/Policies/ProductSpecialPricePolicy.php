<?php

namespace App\Modules\Suppliers\Catalog\Policies;

use App\Models\User;
use App\Modules\Suppliers\Catalog\Models\ProductSpecialPrice;

class ProductSpecialPricePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ProductSpecialPrice $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ProductSpecialPrice $record): bool
    {
        return true;
    }

    public function delete(User $user, ProductSpecialPrice $record): bool
    {
        return true;
    }
}
