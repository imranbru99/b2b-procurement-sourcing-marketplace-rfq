<?php

namespace App\Modules\Suppliers\KycOnboarding\Policies;

use App\Models\User;
use App\Modules\Suppliers\KycOnboarding\Models\KycApplication;

class KycApplicationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, KycApplication $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, KycApplication $record): bool
    {
        return true;
    }

    public function delete(User $user, KycApplication $record): bool
    {
        return true;
    }
}
