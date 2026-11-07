<?php

namespace App\Modules\Orders\Payments\Policies;

use App\Models\User;
use App\Modules\Orders\Payments\Models\PaymentSchedule;
use App\Modules\Orders\Payments\Policies\Concerns\AuthorizesOrganizationEntity;

class PaymentSchedulePolicy
{
    use AuthorizesOrganizationEntity;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, PaymentSchedule $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, PaymentSchedule $model): bool
    {
        return $this->sameOrganization($user, $model);
    }

    public function delete(User $user, PaymentSchedule $model): bool
    {
        return $this->sameOrganization($user, $model);
    }
}
