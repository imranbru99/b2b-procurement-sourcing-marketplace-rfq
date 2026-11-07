<?php

namespace App\Modules\Orders\GoodsReceipt\Policies;

use App\Models\User;
use App\Modules\Orders\GoodsReceipt\Models\QcInspection;
use App\Modules\Orders\GoodsReceipt\Policies\Concerns\AuthorizesOrganizationEntity;

class QcInspectionPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, QcInspection $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, QcInspection $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, QcInspection $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
