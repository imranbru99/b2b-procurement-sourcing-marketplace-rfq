<?php

namespace App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\ApiLogResource\Pages;

use App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\ApiLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateApiLog extends CreateRecord
{
    protected static string $resource = ApiLogResource::class;
}
