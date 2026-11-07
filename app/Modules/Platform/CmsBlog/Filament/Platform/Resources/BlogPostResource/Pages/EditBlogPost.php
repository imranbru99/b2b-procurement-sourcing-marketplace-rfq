<?php

namespace App\Modules\Platform\CmsBlog\Filament\Platform\Resources\BlogPostResource\Pages;

use App\Modules\Platform\CmsBlog\Filament\Platform\Resources\BlogPostResource;
use Filament\Resources\Pages\EditRecord;

class EditBlogPost extends EditRecord
{
    protected static string $resource = BlogPostResource::class;
}
