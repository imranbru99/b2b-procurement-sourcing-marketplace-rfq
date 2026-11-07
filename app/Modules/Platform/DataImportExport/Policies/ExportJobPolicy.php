<?php

namespace App\Modules\Platform\DataImportExport\Policies;

use App\Models\User;
use App\Modules\Platform\DataImportExport\Models\ExportJob;

class ExportJobPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, ExportJob $record): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, ExportJob $record): bool { return true; }
    public function delete(User $user, ExportJob $record): bool { return true; }
}
