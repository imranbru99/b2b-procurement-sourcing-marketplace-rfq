<?php

namespace App\Modules\Platform\MultiLanguagePdf\Policies;

use App\Models\User;
use App\Modules\Platform\MultiLanguagePdf\Models\DocumentTemplate;

class DocumentTemplatePolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, DocumentTemplate $record): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, DocumentTemplate $record): bool { return true; }
    public function delete(User $user, DocumentTemplate $record): bool { return true; }
}
