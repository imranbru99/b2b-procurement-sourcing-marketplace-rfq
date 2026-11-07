<?php

namespace App\Modules\Platform\DataImportExport\Filament\Platform\Resources\ExportJobResource\Pages;

use App\Modules\Platform\DataImportExport\Filament\Platform\Resources\ExportJobResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExportJob extends CreateRecord
{
    protected static string $resource = ExportJobResource::class;
}
