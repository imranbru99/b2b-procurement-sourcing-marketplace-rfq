<?php

namespace App\Modules\Sourcing\Negotiation\Policies;

use App\Models\User;
use App\Modules\Sourcing\Concerns\AuthorizesSourcingAccess;
use App\Modules\Sourcing\Negotiation\Models\Negotiation;

class NegotiationPolicy
{
    use AuthorizesSourcingAccess;

    public function viewAny(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.negotiation', $user)
            && $this->userCan($user, 'negotiations.view');
    }

    public function create(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.negotiation', $user)
            && $this->userCan($user, 'negotiations.create');
    }
}
