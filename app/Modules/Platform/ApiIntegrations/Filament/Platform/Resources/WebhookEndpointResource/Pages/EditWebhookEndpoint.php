<?php

namespace App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\WebhookEndpointResource\Pages;

use App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\WebhookEndpointResource;
use Filament\Resources\Pages\EditRecord;

class EditWebhookEndpoint extends EditRecord
{
    protected static string $resource = WebhookEndpointResource::class;
}
