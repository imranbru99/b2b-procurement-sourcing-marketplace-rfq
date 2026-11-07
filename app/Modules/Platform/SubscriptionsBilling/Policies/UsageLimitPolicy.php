<?php

namespace App\Modules\Platform\SubscriptionsBilling\Policies;

use App\Models\User;
use App\Modules\Platform\SubscriptionsBilling\Models\UsageLimit;

class UsageLimitPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, UsageLimit $record): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, UsageLimit $record): bool { return true; }
    public function delete(User $user, UsageLimit $record): bool { return true; }
}
