<?php

namespace App\Modules\Platform\ApiIntegrations\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\ApiIntegrations\Database\Factories\WebhookEndpointFactory;
use App\Models\Concerns\BelongsToOrganization;

class WebhookEndpoint extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $table = 'api_webhook_endpoints';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['events' => 'array'];
    }

    protected static function newFactory(): WebhookEndpointFactory
    {
        return WebhookEndpointFactory::new();
    }
}
