<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    protected $fillable = [
        'key',
        'name',
        'description',
        'group',
        'icon',
        'is_core',
        'default_enabled',
        'dependencies',
        'permissions',
    ];

    protected function casts(): array
    {
        return [
            'is_core' => 'boolean',
            'default_enabled' => 'boolean',
            'dependencies' => 'array',
            'permissions' => 'array',
        ];
    }

    public function organizationModules(): HasMany
    {
        return $this->hasMany(OrganizationModule::class, 'module_key', 'key');
    }
}
