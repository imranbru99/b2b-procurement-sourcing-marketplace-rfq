<?php

namespace App\Modules\Platform\ApiIntegrations\Policies;

use App\Models\User;
use App\Modules\Platform\ApiIntegrations\Models\ErpConnector;

class ErpConnectorPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, ErpConnector $record): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, ErpConnector $record): bool { return true; }
    public function delete(User $user, ErpConnector $record): bool { return true; }
}
