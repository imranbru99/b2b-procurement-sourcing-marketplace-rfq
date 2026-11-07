<?php

namespace App\Modules\Platform\ApiIntegrations\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\ApiIntegrations\Database\Factories\WebhookDeliveryFactory;

class WebhookDelivery extends Model
{
    use HasFactory;

    protected $table = 'api_webhook_deliveries';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['payload' => 'array'];
    }

    protected static function newFactory(): WebhookDeliveryFactory
    {
        return WebhookDeliveryFactory::new();
    }
}
