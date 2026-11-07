<?php

namespace App\Modules\Sourcing\Bidding\Policies;

use App\Models\User;
use App\Modules\Sourcing\Bidding\Models\Bid;
use App\Modules\Sourcing\Concerns\AuthorizesSourcingAccess;

class BidPolicy
{
    use AuthorizesSourcingAccess;

    public function viewAny(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.bidding', $user)
            && $this->userCan($user, 'bids.view');
    }

    public function create(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.bidding', $user)
            && $this->userCan($user, 'bids.create');
    }

    public function update(?User $user, Bid $bid): bool
    {
        return $this->sourcingModuleEnabled('sourcing.bidding', $user)
            && $this->userCan($user, 'bids.submit');
    }
}
