<?php

namespace App\Modules\Platform\SecurityCenter\Policies;

use App\Models\User;
use App\Modules\Platform\SecurityCenter\Models\SecuritySetting;

class SecuritySettingPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, SecuritySetting $record): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, SecuritySetting $record): bool { return true; }
    public function delete(User $user, SecuritySetting $record): bool { return true; }
}
