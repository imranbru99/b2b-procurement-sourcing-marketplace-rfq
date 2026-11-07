<?php

namespace App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\WebhookDeliveryResource\Pages;

use App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\WebhookDeliveryResource;
use Filament\Resources\Pages\EditRecord;

class EditWebhookDelivery extends EditRecord
{
    protected static string $resource = WebhookDeliveryResource::class;
}
