<?php

namespace App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\WebhookDeliveryResource\Pages;

use App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\WebhookDeliveryResource;
use Filament\Resources\Pages\ListRecords;

class ListWebhookDeliverys extends ListRecords
{
    protected static string $resource = WebhookDeliveryResource::class;
}
