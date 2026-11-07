<?php

namespace App\Modules\Suppliers\LeadsAdvertising\Policies;

use App\Models\User;
use App\Modules\Suppliers\LeadsAdvertising\Models\SponsoredListing;

class SponsoredListingPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, SponsoredListing $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, SponsoredListing $record): bool
    {
        return true;
    }

    public function delete(User $user, SponsoredListing $record): bool
    {
        return true;
    }
}
