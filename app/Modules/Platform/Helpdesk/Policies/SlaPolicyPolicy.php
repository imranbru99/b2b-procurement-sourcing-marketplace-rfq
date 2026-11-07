<?php

namespace App\Modules\Platform\Helpdesk\Policies;

use App\Models\User;
use App\Modules\Platform\Helpdesk\Models\SlaPolicy;

class SlaPolicyPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, SlaPolicy $record): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, SlaPolicy $record): bool { return true; }
    public function delete(User $user, SlaPolicy $record): bool { return true; }
}
