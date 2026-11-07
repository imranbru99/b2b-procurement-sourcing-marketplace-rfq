<?php

namespace App\Modules\Suppliers\Directory\Policies;

use App\Models\User;
use App\Modules\Suppliers\Directory\Models\SupplierCertification;

class SupplierCertificationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, SupplierCertification $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, SupplierCertification $record): bool
    {
        return true;
    }

    public function delete(User $user, SupplierCertification $record): bool
    {
        return true;
    }
}
