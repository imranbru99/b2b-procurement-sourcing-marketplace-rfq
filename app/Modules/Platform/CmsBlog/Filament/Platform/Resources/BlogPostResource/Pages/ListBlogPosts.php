<?php

namespace App\Modules\Platform\CmsBlog\Filament\Platform\Resources\BlogPostResource\Pages;

use App\Modules\Platform\CmsBlog\Filament\Platform\Resources\BlogPostResource;
use Filament\Resources\Pages\ListRecords;

class ListBlogPosts extends ListRecords
{
    protected static string $resource = BlogPostResource::class;
}
