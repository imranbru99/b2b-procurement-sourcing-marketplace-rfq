<?php

namespace App\Modules\Platform\SecurityCenter\Policies;

use App\Models\User;
use App\Modules\Platform\SecurityCenter\Models\IpAllowlist;

class IpAllowlistPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, IpAllowlist $record): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, IpAllowlist $record): bool { return true; }
    public function delete(User $user, IpAllowlist $record): bool { return true; }
}
