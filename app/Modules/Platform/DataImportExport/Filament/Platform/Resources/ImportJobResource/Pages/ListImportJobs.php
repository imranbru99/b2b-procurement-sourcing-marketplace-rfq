<?php

namespace App\Modules\Platform\DataImportExport\Filament\Platform\Resources\ImportJobResource\Pages;

use App\Modules\Platform\DataImportExport\Filament\Platform\Resources\ImportJobResource;
use Filament\Resources\Pages\ListRecords;

class ListImportJobs extends ListRecords
{
    protected static string $resource = ImportJobResource::class;
}
