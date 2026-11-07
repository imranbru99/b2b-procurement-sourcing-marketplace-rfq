<?php

namespace App\Modules\Operations\Logistics\Policies;

use App\Models\User;
use App\Modules\Operations\Logistics\Models\Carrier;
use App\Modules\Operations\Logistics\Policies\Concerns\AuthorizesOrganizationEntity;

class CarrierPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Carrier $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Carrier $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, Carrier $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
