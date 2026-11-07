<?php

namespace App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\WebhookDeliveryResource\Pages;

use App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\WebhookDeliveryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWebhookDelivery extends CreateRecord
{
    protected static string $resource = WebhookDeliveryResource::class;
}
