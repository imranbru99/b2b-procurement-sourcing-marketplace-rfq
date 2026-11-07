<?php

namespace App\Modules\Orders\GoodsReceipt\Policies;

use App\Models\User;
use App\Modules\Orders\GoodsReceipt\Models\Grn;
use App\Modules\Orders\GoodsReceipt\Policies\Concerns\AuthorizesOrganizationEntity;

class GrnPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Grn $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Grn $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, Grn $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
