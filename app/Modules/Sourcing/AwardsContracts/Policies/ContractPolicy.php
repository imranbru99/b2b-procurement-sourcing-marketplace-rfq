<?php

namespace App\Modules\Sourcing\AwardsContracts\Policies;

use App\Models\User;
use App\Modules\Sourcing\AwardsContracts\Models\Contract;
use App\Modules\Sourcing\Concerns\AuthorizesSourcingAccess;

class ContractPolicy
{
    use AuthorizesSourcingAccess;

    public function viewAny(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.awards-contracts', $user)
            && $this->userCan($user, 'contracts.view');
    }

    public function create(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.awards-contracts', $user)
            && $this->userCan($user, 'contracts.create');
    }
}
