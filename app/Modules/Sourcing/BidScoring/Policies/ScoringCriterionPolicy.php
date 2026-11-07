<?php

namespace App\Modules\Sourcing\BidScoring\Policies;

use App\Models\User;
use App\Modules\Sourcing\BidScoring\Models\ScoringCriterion;
use App\Modules\Sourcing\Concerns\AuthorizesSourcingAccess;

class ScoringCriterionPolicy
{
    use AuthorizesSourcingAccess;

    public function viewAny(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.bid-scoring', $user)
            && $this->userCan($user, 'bid_scoring.view');
    }

    public function create(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.bid-scoring', $user)
            && $this->userCan($user, 'bid_scoring.manage');
    }

    public function update(?User $user, ScoringCriterion $criterion): bool
    {
        return $this->sourcingModuleEnabled('sourcing.bid-scoring', $user)
            && $this->userCan($user, 'bid_scoring.evaluate');
    }
}
