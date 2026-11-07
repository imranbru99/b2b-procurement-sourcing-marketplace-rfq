<?php

namespace App\Modules\Suppliers\KycOnboarding\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Suppliers\KycOnboarding\Database\Factories\SupplierBlacklistFactory;

class SupplierBlacklist extends Model
{
    /** @use HasFactory<SupplierBlacklistFactory> */
    use HasFactory, BelongsToOrganization;

    protected $table = 'supplier_blacklist';

    protected $guarded = [];

    protected static function newFactory(): SupplierBlacklistFactory
    {
        return SupplierBlacklistFactory::new();
    }


    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'variants' => 'array',
            'filters' => 'array',
            'theme' => 'array',
            'seo' => 'array',
            'checklist' => 'array',
            'responses' => 'array',
            'dimensions' => 'array',
            'factors' => 'array',
            'is_active' => 'boolean',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'is_verified' => 'boolean',
            'is_primary' => 'boolean',
            'notify_on_match' => 'boolean',
            'requires_lead_unlock' => 'boolean',
        ];
    }
}
