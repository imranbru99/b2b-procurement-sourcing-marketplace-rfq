<?php

namespace App\Modules\Operations\Messaging\Policies;

use App\Models\User;
use App\Modules\Operations\Messaging\Models\Message;
use App\Modules\Operations\Messaging\Policies\Concerns\AuthorizesOrganizationEntity;

class MessagePolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Message $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Message $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, Message $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
