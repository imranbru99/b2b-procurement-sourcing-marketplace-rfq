<?php

namespace App\Modules\Operations\Messaging\Policies;

use App\Models\User;
use App\Modules\Operations\Messaging\Models\MessageThread;
use App\Modules\Operations\Messaging\Policies\Concerns\AuthorizesOrganizationEntity;

class MessageThreadPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, MessageThread $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, MessageThread $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, MessageThread $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
