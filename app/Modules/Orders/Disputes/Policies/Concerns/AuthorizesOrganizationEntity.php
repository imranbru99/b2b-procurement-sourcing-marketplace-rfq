<?php

namespace App\Modules\Orders\Disputes\Policies\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait AuthorizesOrganizationEntity
{
    protected function sameOrganization(User $user, Model $model): bool
    {
        if (! $user->current_organization_id) {
            return false;
        }

        return (int) $model->getAttribute('organization_id') === (int) $user->current_organization_id;
    }
}
