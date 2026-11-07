<?php

namespace App\Modules\Orders\Invoicing\Policies;

use App\Models\User;
use App\Modules\Orders\Invoicing\Models\CreditNote;
use App\Modules\Orders\Invoicing\Policies\Concerns\AuthorizesOrganizationEntity;

class CreditNotePolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, CreditNote $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, CreditNote $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, CreditNote $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
