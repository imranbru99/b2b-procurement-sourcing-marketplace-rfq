<?php

namespace App\Modules\Core\Settings\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Core\Settings\Database\Factories\SettingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /** @use HasFactory<SettingFactory> */
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'organization_id',
        'group',
        'key',
        'value',
        'is_locked',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'array',
            'is_locked' => 'boolean',
        ];
    }

    protected static function newFactory(): SettingFactory
    {
        return SettingFactory::new();
    }
}
