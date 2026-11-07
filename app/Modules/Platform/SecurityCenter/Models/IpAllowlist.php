<?php

namespace App\Modules\Platform\SecurityCenter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\SecurityCenter\Database\Factories\IpAllowlistFactory;
use App\Models\Concerns\BelongsToOrganization;

class IpAllowlist extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $table = 'security_ip_allowlists';

    protected $guarded = [];

    protected static function newFactory(): IpAllowlistFactory
    {
        return IpAllowlistFactory::new();
    }
}
