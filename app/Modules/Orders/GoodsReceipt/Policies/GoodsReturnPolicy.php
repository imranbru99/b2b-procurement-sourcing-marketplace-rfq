<?php

namespace App\Modules\Orders\GoodsReceipt\Policies;

use App\Models\User;
use App\Modules\Orders\GoodsReceipt\Models\GoodsReturn;
use App\Modules\Orders\GoodsReceipt\Policies\Concerns\AuthorizesOrganizationEntity;

class GoodsReturnPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, GoodsReturn $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, GoodsReturn $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, GoodsReturn $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
