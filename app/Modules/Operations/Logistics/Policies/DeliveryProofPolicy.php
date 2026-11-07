<?php

namespace App\Modules\Operations\Logistics\Policies;

use App\Models\User;
use App\Modules\Operations\Logistics\Models\DeliveryProof;
use App\Modules\Operations\Logistics\Policies\Concerns\AuthorizesOrganizationEntity;

class DeliveryProofPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, DeliveryProof $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, DeliveryProof $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, DeliveryProof $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
