<?php

namespace App\Modules\Intelligence\AiAssistant\Policies;

use App\Models\User;
use App\Modules\Intelligence\AiAssistant\Models\AiUsageLog;
use App\Modules\Operations\Budgets\Policies\Concerns\AuthorizesOrganizationEntity;

class AiUsageLogPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, AiUsageLog $model): bool
    {
        if ($model->organization_id === null) {
            return true;
        }

        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, AiUsageLog $model): bool
    {
        return false;
    }

    public function delete(User $user, AiUsageLog $model): bool
    {
        return false;
    }
}
