<?php

namespace App\Modules\Suppliers\ReviewsScorecards\Policies;

use App\Models\User;
use App\Modules\Suppliers\ReviewsScorecards\Models\SupplierReview;

class SupplierReviewPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, SupplierReview $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, SupplierReview $record): bool
    {
        return true;
    }

    public function delete(User $user, SupplierReview $record): bool
    {
        return true;
    }
}
