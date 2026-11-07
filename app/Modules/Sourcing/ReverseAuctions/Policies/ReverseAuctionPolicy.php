<?php

namespace App\Modules\Sourcing\ReverseAuctions\Policies;

use App\Models\User;
use App\Modules\Sourcing\Concerns\AuthorizesSourcingAccess;
use App\Modules\Sourcing\ReverseAuctions\Models\ReverseAuction;

class ReverseAuctionPolicy
{
    use AuthorizesSourcingAccess;

    public function viewAny(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.reverse-auctions', $user)
            && $this->userCan($user, 'reverse_auctions.view');
    }

    public function create(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.reverse-auctions', $user)
            && $this->userCan($user, 'reverse_auctions.create');
    }
}
