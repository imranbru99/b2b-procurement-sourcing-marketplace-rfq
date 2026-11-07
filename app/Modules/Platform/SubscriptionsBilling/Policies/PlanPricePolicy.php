<?php

namespace App\Modules\Platform\SubscriptionsBilling\Policies;

use App\Models\User;
use App\Modules\Platform\SubscriptionsBilling\Models\PlanPrice;

class PlanPricePolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, PlanPrice $record): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, PlanPrice $record): bool { return true; }
    public function delete(User $user, PlanPrice $record): bool { return true; }
}
