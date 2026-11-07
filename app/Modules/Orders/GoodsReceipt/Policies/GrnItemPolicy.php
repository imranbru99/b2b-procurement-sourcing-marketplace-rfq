<?php

namespace App\Modules\Orders\GoodsReceipt\Policies;

use App\Models\User;
use App\Modules\Orders\GoodsReceipt\Models\GrnItem;
use App\Modules\Orders\GoodsReceipt\Policies\Concerns\AuthorizesOrganizationEntity;

class GrnItemPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, GrnItem $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, GrnItem $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, GrnItem $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
