<?php

namespace App\Modules\Orders\Disputes\Policies;

use App\Models\User;
use App\Modules\Orders\Disputes\Models\DisputeEvidence;
use App\Modules\Orders\Disputes\Policies\Concerns\AuthorizesOrganizationEntity;

class DisputeEvidencePolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, DisputeEvidence $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, DisputeEvidence $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, DisputeEvidence $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
