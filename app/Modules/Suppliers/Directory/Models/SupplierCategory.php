<?php

namespace App\Modules\Suppliers\Directory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ImranDev\UniversalSlug\Attributes\Slug;
use ImranDev\UniversalSlug\Traits\HasUniversalSlug;
use App\Modules\Suppliers\Directory\Database\Factories\SupplierCategoryFactory;

#[Slug(from: 'name')]
class SupplierCategory extends Model
{
    /** @use HasFactory<SupplierCategoryFactory> */
    use HasFactory, HasUniversalSlug;

    protected $table = 'supplier_categories';

    protected $guarded = [];

    protected static function newFactory(): SupplierCategoryFactory
    {
        return SupplierCategoryFactory::new();
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
