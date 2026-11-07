<?php

namespace App\Modules\Suppliers\RiskCompliance\Policies;

use App\Models\User;
use App\Modules\Suppliers\RiskCompliance\Models\RiskScore;

class RiskScorePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, RiskScore $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, RiskScore $record): bool
    {
        return true;
    }

    public function delete(User $user, RiskScore $record): bool
    {
        return true;
    }
}
