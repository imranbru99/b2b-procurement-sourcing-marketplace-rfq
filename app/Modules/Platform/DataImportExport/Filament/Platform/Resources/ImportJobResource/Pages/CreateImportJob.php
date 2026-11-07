<?php

namespace App\Modules\Platform\DataImportExport\Filament\Platform\Resources\ImportJobResource\Pages;

use App\Modules\Platform\DataImportExport\Filament\Platform\Resources\ImportJobResource;
use Filament\Resources\Pages\CreateRecord;

class CreateImportJob extends CreateRecord
{
    protected static string $resource = ImportJobResource::class;
}
