<?php

namespace App\Modules\Sourcing\AwardsContracts\Policies;

use App\Models\User;
use App\Modules\Sourcing\AwardsContracts\Models\Award;
use App\Modules\Sourcing\Concerns\AuthorizesSourcingAccess;

class AwardPolicy
{
    use AuthorizesSourcingAccess;

    public function viewAny(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.awards-contracts', $user)
            && $this->userCan($user, 'awards.view');
    }

    public function create(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.awards-contracts', $user)
            && $this->userCan($user, 'awards.create');
    }
}
