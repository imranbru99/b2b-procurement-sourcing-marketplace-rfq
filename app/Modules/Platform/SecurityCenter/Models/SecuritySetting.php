<?php

namespace App\Modules\Platform\SecurityCenter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\SecurityCenter\Database\Factories\SecuritySettingFactory;
use App\Models\Concerns\BelongsToOrganization;

class SecuritySetting extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $table = 'security_settings';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['settings' => 'array'];
    }

    protected static function newFactory(): SecuritySettingFactory
    {
        return SecuritySettingFactory::new();
    }
}
