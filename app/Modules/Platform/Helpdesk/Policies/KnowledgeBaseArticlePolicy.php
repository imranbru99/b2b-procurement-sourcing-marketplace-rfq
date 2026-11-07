<?php

namespace App\Modules\Platform\Helpdesk\Policies;

use App\Models\User;
use App\Modules\Platform\Helpdesk\Models\KnowledgeBaseArticle;

class KnowledgeBaseArticlePolicy
{
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, KnowledgeBaseArticle $record): bool { return true; }
    public function create(User $user): bool { return true; }
    public function update(User $user, KnowledgeBaseArticle $record): bool { return true; }
    public function delete(User $user, KnowledgeBaseArticle $record): bool { return true; }
}
