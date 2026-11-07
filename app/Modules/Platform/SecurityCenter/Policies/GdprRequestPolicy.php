<?php

namespace App\Modules\Platform\SecurityCenter\Policies;

use App\Models\User;
use App\Modules\Platform\SecurityCenter\Models\GdprRequest;

class GdprRequestPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, GdprRequest $record): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, GdprRequest $record): bool { return true; }
    public function delete(User $user, GdprRequest $record): bool { return true; }
}
