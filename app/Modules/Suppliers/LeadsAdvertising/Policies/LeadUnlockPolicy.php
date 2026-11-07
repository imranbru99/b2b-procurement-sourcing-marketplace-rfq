<?php

namespace App\Modules\Suppliers\LeadsAdvertising\Policies;

use App\Models\User;
use App\Modules\Suppliers\LeadsAdvertising\Models\LeadUnlock;

class LeadUnlockPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, LeadUnlock $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, LeadUnlock $record): bool
    {
        return true;
    }

    public function delete(User $user, LeadUnlock $record): bool
    {
        return true;
    }
}
