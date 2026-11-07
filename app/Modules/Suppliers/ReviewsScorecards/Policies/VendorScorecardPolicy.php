<?php

namespace App\Modules\Suppliers\ReviewsScorecards\Policies;

use App\Models\User;
use App\Modules\Suppliers\ReviewsScorecards\Models\VendorScorecard;

class VendorScorecardPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, VendorScorecard $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, VendorScorecard $record): bool
    {
        return true;
    }

    public function delete(User $user, VendorScorecard $record): bool
    {
        return true;
    }
}
