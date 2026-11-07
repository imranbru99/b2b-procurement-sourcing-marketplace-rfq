<?php

namespace App\Modules\Platform\CmsBlog\Policies;

use App\Models\User;
use App\Modules\Platform\CmsBlog\Models\Banner;

class BannerPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Banner $record): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, Banner $record): bool { return true; }
    public function delete(User $user, Banner $record): bool { return true; }
}
