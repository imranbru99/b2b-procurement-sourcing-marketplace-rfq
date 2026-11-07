<?php

namespace App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\WebhookEndpointResource\Pages;

use App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\WebhookEndpointResource;
use Filament\Resources\Pages\ListRecords;

class ListWebhookEndpoints extends ListRecords
{
    protected static string $resource = WebhookEndpointResource::class;
}
