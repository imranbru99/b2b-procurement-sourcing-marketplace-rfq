<?php

namespace App\Modules\Sourcing\PurchaseRequisitions\Policies;

use App\Models\User;
use App\Modules\Sourcing\Concerns\AuthorizesSourcingAccess;
use App\Modules\Sourcing\PurchaseRequisitions\Models\PurchaseRequisition;

class PurchaseRequisitionPolicy
{
    use AuthorizesSourcingAccess;

    public function viewAny(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.purchase-requisitions', $user)
            && $this->userCan($user, 'purchase_requisitions.view');
    }

    public function create(?User $user): bool
    {
        return $this->sourcingModuleEnabled('sourcing.purchase-requisitions', $user)
            && $this->userCan($user, 'purchase_requisitions.create');
    }

    public function update(?User $user, PurchaseRequisition $requisition): bool
    {
        return $this->sourcingModuleEnabled('sourcing.purchase-requisitions', $user)
            && $this->userCan($user, 'purchase_requisitions.update');
    }
}
