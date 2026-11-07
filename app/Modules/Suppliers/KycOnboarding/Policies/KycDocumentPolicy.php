<?php

namespace App\Modules\Suppliers\KycOnboarding\Policies;

use App\Models\User;
use App\Modules\Suppliers\KycOnboarding\Models\KycDocument;

class KycDocumentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, KycDocument $record): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, KycDocument $record): bool
    {
        return true;
    }

    public function delete(User $user, KycDocument $record): bool
    {
        return true;
    }
}
