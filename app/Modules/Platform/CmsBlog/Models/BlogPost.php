<?php

namespace App\Modules\Platform\CmsBlog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\CmsBlog\Database\Factories\BlogPostFactory;
use App\Models\Concerns\BelongsToOrganization;
use ImranDev\UniversalSlug\Attributes\Slug;
use ImranDev\UniversalSlug\Traits\HasUniversalSlug;

#[Slug(from: 'title')]
class BlogPost extends Model
{
    use HasFactory, BelongsToOrganization, HasUniversalSlug;

    protected $table = 'cms_blog_posts';

    protected $guarded = [];


    protected function casts(): array
    {
        return [
            'content' => 'array',
        ];
    }

    protected static function newFactory(): BlogPostFactory
    {
        return BlogPostFactory::new();
    }
}
