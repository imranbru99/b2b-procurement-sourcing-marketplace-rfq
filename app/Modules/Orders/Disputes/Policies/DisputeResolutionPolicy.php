<?php

namespace App\Modules\Orders\Disputes\Policies;

use App\Models\User;
use App\Modules\Orders\Disputes\Models\DisputeResolution;
use App\Modules\Orders\Disputes\Policies\Concerns\AuthorizesOrganizationEntity;

class DisputeResolutionPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, DisputeResolution $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, DisputeResolution $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, DisputeResolution $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
