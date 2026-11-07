<?php

namespace App\Modules\Platform\ApiIntegrations\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\ApiIntegrations\Database\Factories\ApiLogFactory;
use App\Models\Concerns\BelongsToOrganization;

class ApiLog extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $table = 'api_logs';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['request_body' => 'array', 'response_body' => 'array'];
    }

    protected static function newFactory(): ApiLogFactory
    {
        return ApiLogFactory::new();
    }
}
