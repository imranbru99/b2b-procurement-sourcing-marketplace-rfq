<?php

namespace App\Modules\Suppliers\ReviewsScorecards\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Suppliers\ReviewsScorecards\Database\Factories\SupplierReviewFactory;

class SupplierReview extends Model
{
    /** @use HasFactory<SupplierReviewFactory> */
    use HasFactory;

    protected $table = 'supplier_reviews';

    protected $guarded = [];

    protected static function newFactory(): SupplierReviewFactory
    {
        return SupplierReviewFactory::new();
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
