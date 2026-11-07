<?php

namespace App\Modules\Platform\CmsBlog\Filament\Platform\Resources\BlogPostResource\Pages;

use App\Modules\Platform\CmsBlog\Filament\Platform\Resources\BlogPostResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogPost extends CreateRecord
{
    protected static string $resource = BlogPostResource::class;
}
