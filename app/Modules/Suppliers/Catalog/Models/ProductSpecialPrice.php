<?php

namespace App\Modules\Suppliers\Catalog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Suppliers\Catalog\Database\Factories\ProductSpecialPriceFactory;

class ProductSpecialPrice extends Model
{
    /** @use HasFactory<ProductSpecialPriceFactory> */
    use HasFactory;

    protected $table = 'product_special_prices';

    protected $guarded = [];

    protected static function newFactory(): ProductSpecialPriceFactory
    {
        return ProductSpecialPriceFactory::new();
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
