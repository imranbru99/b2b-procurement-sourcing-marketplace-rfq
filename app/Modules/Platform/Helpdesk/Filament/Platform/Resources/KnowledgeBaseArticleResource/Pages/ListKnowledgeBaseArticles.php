<?php

namespace App\Modules\Platform\Helpdesk\Filament\Platform\Resources\KnowledgeBaseArticleResource\Pages;

use App\Modules\Platform\Helpdesk\Filament\Platform\Resources\KnowledgeBaseArticleResource;
use Filament\Resources\Pages\ListRecords;

class ListKnowledgeBaseArticles extends ListRecords
{
    protected static string $resource = KnowledgeBaseArticleResource::class;
}
