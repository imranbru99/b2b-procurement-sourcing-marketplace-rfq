<?php

namespace App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\ApiLogResource\Pages;

use App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\ApiLogResource;
use Filament\Resources\Pages\ListRecords;

class ListApiLogs extends ListRecords
{
    protected static string $resource = ApiLogResource::class;
}
