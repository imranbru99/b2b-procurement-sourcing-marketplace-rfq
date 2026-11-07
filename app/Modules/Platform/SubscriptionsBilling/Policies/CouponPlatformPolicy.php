<?php

namespace App\Modules\Platform\SubscriptionsBilling\Policies;

use App\Models\User;
use App\Modules\Platform\SubscriptionsBilling\Models\CouponPlatform;

class CouponPlatformPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, CouponPlatform $record): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, CouponPlatform $record): bool { return true; }
    public function delete(User $user, CouponPlatform $record): bool { return true; }
}
