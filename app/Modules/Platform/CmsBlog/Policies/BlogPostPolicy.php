<?php

namespace App\Modules\Platform\CmsBlog\Policies;

use App\Models\User;
use App\Modules\Platform\CmsBlog\Models\BlogPost;

class BlogPostPolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, BlogPost $record): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, BlogPost $record): bool { return true; }
    public function delete(User $user, BlogPost $record): bool { return true; }
}
