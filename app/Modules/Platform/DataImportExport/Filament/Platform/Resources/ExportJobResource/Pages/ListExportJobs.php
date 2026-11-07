<?php

namespace App\Modules\Platform\DataImportExport\Filament\Platform\Resources\ExportJobResource\Pages;

use App\Modules\Platform\DataImportExport\Filament\Platform\Resources\ExportJobResource;
use Filament\Resources\Pages\ListRecords;

class ListExportJobs extends ListRecords
{
    protected static string $resource = ExportJobResource::class;
}
