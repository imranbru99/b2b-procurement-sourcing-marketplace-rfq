<?php

namespace App\Modules\Platform\Helpdesk\Policies;

use App\Models\User;
use App\Modules\Platform\Helpdesk\Models\TicketReply;

class TicketReplyPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, TicketReply $record): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, TicketReply $record): bool { return true; }
    public function delete(User $user, TicketReply $record): bool { return true; }
}
