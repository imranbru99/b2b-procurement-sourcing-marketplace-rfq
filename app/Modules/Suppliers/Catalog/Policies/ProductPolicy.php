<?php

namespace App\Modules\Suppliers\Catalog\Policies;

use App\Models\User;
use App\Modules\Suppliers\Catalog\Models\Product;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Product $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Product $record): bool
    {
        return true;
    }

    public function delete(User $user, Product $record): bool
    {
        return true;
    }
}
