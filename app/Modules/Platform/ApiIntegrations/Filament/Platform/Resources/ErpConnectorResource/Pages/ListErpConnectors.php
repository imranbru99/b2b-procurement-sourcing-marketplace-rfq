<?php

namespace App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\ErpConnectorResource\Pages;

use App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\ErpConnectorResource;
use Filament\Resources\Pages\ListRecords;

class ListErpConnectors extends ListRecords
{
    protected static string $resource = ErpConnectorResource::class;
}
