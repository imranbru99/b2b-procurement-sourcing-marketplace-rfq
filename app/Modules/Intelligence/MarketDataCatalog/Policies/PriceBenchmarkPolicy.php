<?php

namespace App\Modules\Intelligence\MarketDataCatalog\Policies;

use App\Models\User;
use App\Modules\Intelligence\MarketDataCatalog\Models\PriceBenchmark;
use App\Modules\Operations\Budgets\Policies\Concerns\AuthorizesOrganizationEntity;

class PriceBenchmarkPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, PriceBenchmark $model): bool
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

    public function update(User $user, PriceBenchmark $model): bool
    {
        if ($model->organization_id === null) {
            return true;
        }

        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, PriceBenchmark $model): bool
    {
        if ($model->organization_id === null) {
            return false;
        }

        return $this->sameOrganization($user, $model);
    }
}
