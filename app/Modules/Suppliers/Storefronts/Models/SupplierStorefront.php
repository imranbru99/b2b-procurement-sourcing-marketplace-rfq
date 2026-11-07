<?php

namespace App\Modules\Suppliers\Storefronts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Suppliers\Storefronts\Database\Factories\SupplierStorefrontFactory;

class SupplierStorefront extends Model
{
    /** @use HasFactory<SupplierStorefrontFactory> */
    use HasFactory;

    protected $table = 'supplier_storefronts';

    protected $guarded = [];

    protected static function newFactory(): SupplierStorefrontFactory
    {
        return SupplierStorefrontFactory::new();
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
