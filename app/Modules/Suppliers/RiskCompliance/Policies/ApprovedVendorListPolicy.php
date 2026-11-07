<?php

namespace App\Modules\Suppliers\RiskCompliance\Policies;

use App\Models\User;
use App\Modules\Suppliers\RiskCompliance\Models\ApprovedVendorList;

class ApprovedVendorListPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ApprovedVendorList $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ApprovedVendorList $record): bool
    {
        return true;
    }

    public function delete(User $user, ApprovedVendorList $record): bool
    {
        return true;
    }
}
