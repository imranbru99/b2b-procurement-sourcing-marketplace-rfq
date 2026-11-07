<?php

namespace App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\ApiLogResource\Pages;

use App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\ApiLogResource;
use Filament\Resources\Pages\EditRecord;

class EditApiLog extends EditRecord
{
    protected static string $resource = ApiLogResource::class;
}
