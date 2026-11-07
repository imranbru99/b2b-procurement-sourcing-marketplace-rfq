<?php

namespace App\Modules\Platform\DataImportExport\Policies;

use App\Models\User;
use App\Modules\Platform\DataImportExport\Models\ImportJob;

class ImportJobPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, ImportJob $record): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, ImportJob $record): bool { return true; }
    public function delete(User $user, ImportJob $record): bool { return true; }
}
