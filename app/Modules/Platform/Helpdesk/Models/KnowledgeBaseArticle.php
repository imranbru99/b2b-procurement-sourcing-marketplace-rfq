<?php

namespace App\Modules\Platform\Helpdesk\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\Helpdesk\Database\Factories\KnowledgeBaseArticleFactory;
use App\Models\Concerns\BelongsToOrganization;
use ImranDev\UniversalSlug\Attributes\Slug;
use ImranDev\UniversalSlug\Traits\HasUniversalSlug;

#[Slug(from: 'title')]
class KnowledgeBaseArticle extends Model
{
    use HasFactory, BelongsToOrganization, HasUniversalSlug;

    protected $table = 'helpdesk_knowledge_base_articles';

    protected $guarded = [];

    protected static function newFactory(): KnowledgeBaseArticleFactory
    {
        return KnowledgeBaseArticleFactory::new();
    }
}
