<?php

namespace App\Modules\Platform\SecurityCenter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\SecurityCenter\Database\Factories\GdprRequestFactory;
use App\Models\Concerns\BelongsToOrganization;

class GdprRequest extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $table = 'security_gdpr_requests';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['payload' => 'array'];
    }

    protected static function newFactory(): GdprRequestFactory
    {
        return GdprRequestFactory::new();
    }
}
