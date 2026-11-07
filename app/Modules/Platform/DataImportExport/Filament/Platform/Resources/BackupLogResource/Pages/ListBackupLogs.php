<?php

namespace App\Modules\Platform\DataImportExport\Filament\Platform\Resources\BackupLogResource\Pages;

use App\Modules\Platform\DataImportExport\Filament\Platform\Resources\BackupLogResource;
use Filament\Resources\Pages\ListRecords;

class ListBackupLogs extends ListRecords
{
    protected static string $resource = BackupLogResource::class;
}
