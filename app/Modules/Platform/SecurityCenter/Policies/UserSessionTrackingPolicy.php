<?php

namespace App\Modules\Platform\SecurityCenter\Policies;

use App\Models\User;
use App\Modules\Platform\SecurityCenter\Models\UserSessionTracking;

class UserSessionTrackingPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, UserSessionTracking $record): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, UserSessionTracking $record): bool { return true; }
    public function delete(User $user, UserSessionTracking $record): bool { return true; }
}
