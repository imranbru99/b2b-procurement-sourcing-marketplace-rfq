<?php

namespace App\Modules\Platform\CmsBlog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\CmsBlog\Database\Factories\FaqFactory;
use App\Models\Concerns\BelongsToOrganization;
use ImranDev\UniversalSlug\Attributes\Slug;
use ImranDev\UniversalSlug\Traits\HasUniversalSlug;

#[Slug(from: 'question')]
class Faq extends Model
{
    use HasFactory, BelongsToOrganization, HasUniversalSlug;

    protected $table = 'cms_faqs';

    protected $guarded = [];


    protected function casts(): array
    {
        return [
            'content' => 'array',
        ];
    }

    protected static function newFactory(): FaqFactory
    {
        return FaqFactory::new();
    }
}
