<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Organization extends Model
{
    /** @use HasFactory<\Database\Factories\OrganizationFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'legal_name',
        'tax_id',
        'email',
        'phone',
        'country',
        'timezone',
        'locale',
        'settings',
        'is_active',
    ];

    protected $appends = [
        'currency',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Organization $organization): void {
            if (! $organization->slug) {
                $organization->slug = Str::slug($organization->name);
            }
        });
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'organization_user')
            ->using(OrganizationUser::class)
            ->withPivot(['role', 'is_primary', 'invited_at', 'joined_at'])
            ->withTimestamps();
    }

    public function organizationModules(): HasMany
    {
        return $this->hasMany(OrganizationModule::class);
    }

    public function getCurrencyAttribute(): string
    {
        $settings = $this->settings ?? [];

        return (string) ($settings['currency'] ?? 'USD');
    }

    public function setCurrencyAttribute(?string $value): void
    {
        $settings = $this->settings ?? [];
        $settings['currency'] = strtoupper((string) ($value ?: 'USD'));
        $this->settings = $settings;
    }

    public function getStatusAttribute(): string
    {
        return $this->is_active ? 'active' : 'inactive';
    }

    public function setStatusAttribute(string|bool|null $value): void
    {
        if (is_bool($value)) {
            $this->is_active = $value;

            return;
        }

        $this->is_active = in_array(strtolower((string) $value), ['active', '1', 'true'], true);
    }
}
