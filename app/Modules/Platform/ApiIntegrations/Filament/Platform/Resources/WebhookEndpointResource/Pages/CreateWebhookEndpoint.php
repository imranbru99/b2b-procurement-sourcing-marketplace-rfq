<?php

namespace App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\WebhookEndpointResource\Pages;

use App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\WebhookEndpointResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWebhookEndpoint extends CreateRecord
{
    protected static string $resource = WebhookEndpointResource::class;
}
