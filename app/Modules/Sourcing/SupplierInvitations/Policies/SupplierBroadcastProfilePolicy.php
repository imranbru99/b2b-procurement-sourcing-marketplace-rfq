<?php

namespace App\Modules\Sourcing\SupplierInvitations\Policies;

use App\Models\User;
use App\Modules\Sourcing\Concerns\AuthorizesSourcingAccess;
use App\Modules\Sourcing\SupplierInvitations\Models\SupplierBroadcastProfile;

class SupplierBroadcastProfilePolicy
{
    use AuthorizesSourcingAccess;

    public function viewAny(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.supplier-invitations', $user)
            && $this->userCan($user, 'supplier_invitations.view');
    }

    public function create(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.supplier-invitations', $user)
            && $this->userCan($user, 'supplier_invitations.broadcast');
    }
}
