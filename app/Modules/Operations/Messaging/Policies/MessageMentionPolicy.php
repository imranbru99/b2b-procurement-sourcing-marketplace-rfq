<?php

namespace App\Modules\Operations\Messaging\Policies;

use App\Models\User;
use App\Modules\Operations\Messaging\Models\MessageMention;
use App\Modules\Operations\Messaging\Policies\Concerns\AuthorizesOrganizationEntity;

class MessageMentionPolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, MessageMention $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, MessageMention $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, MessageMention $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
