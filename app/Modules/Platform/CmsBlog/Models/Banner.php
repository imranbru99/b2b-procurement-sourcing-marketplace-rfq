<?php

namespace App\Modules\Platform\CmsBlog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\CmsBlog\Database\Factories\BannerFactory;
use App\Models\Concerns\BelongsToOrganization;
use ImranDev\UniversalSlug\Attributes\Slug;
use ImranDev\UniversalSlug\Traits\HasUniversalSlug;

#[Slug(from: 'title')]
class Banner extends Model
{
    use HasFactory, BelongsToOrganization, HasUniversalSlug;

    protected $table = 'cms_banners';

    protected $guarded = [];


    protected function casts(): array
    {
        return [
            'content' => 'array',
        ];
    }

    protected static function newFactory(): BannerFactory
    {
        return BannerFactory::new();
    }
}
