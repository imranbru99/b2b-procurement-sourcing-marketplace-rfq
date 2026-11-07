<?php

namespace App\Modules\Sourcing\Rfqs\Policies;

use App\Models\User;
use App\Modules\Sourcing\Concerns\AuthorizesSourcingAccess;
use App\Modules\Sourcing\Rfqs\Models\Rfq;

class RfqPolicy
{
    use AuthorizesSourcingAccess;

    public function viewAny(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.rfqs', $user)
            && $this->userCan($user, 'rfqs.view');
    }

    public function view(?User $user, Rfq $rfq): bool
    {
        return $this->viewAny($user);
    }

    public function create(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.rfqs', $user)
            && $this->userCan($user, 'rfqs.create');
    }

    public function update(?User $user, Rfq $rfq): bool
    {
        return $this->sourcingModuleEnabled('sourcing.rfqs', $user)
            && $this->userCan($user, 'rfqs.update');
    }

    public function delete(?User $user, Rfq $rfq): bool
    {
        return $this->sourcingModuleEnabled('sourcing.rfqs', $user)
            && $this->userCan($user, 'rfqs.delete');
    }
}
