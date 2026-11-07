<?php

namespace App\Modules\Platform\MultiLanguagePdf\Filament\Platform\Resources\DocumentTemplateResource\Pages;

use App\Modules\Platform\MultiLanguagePdf\Filament\Platform\Resources\DocumentTemplateResource;
use Filament\Resources\Pages\ListRecords;

class ListDocumentTemplates extends ListRecords
{
    protected static string $resource = DocumentTemplateResource::class;
}
