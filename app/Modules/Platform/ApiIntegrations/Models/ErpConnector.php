<?php

namespace App\Modules\Platform\ApiIntegrations\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\ApiIntegrations\Database\Factories\ErpConnectorFactory;
use App\Models\Concerns\BelongsToOrganization;

class ErpConnector extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $table = 'api_erp_connectors';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['credentials' => 'array'];
    }

    protected static function newFactory(): ErpConnectorFactory
    {
        return ErpConnectorFactory::new();
    }
}
