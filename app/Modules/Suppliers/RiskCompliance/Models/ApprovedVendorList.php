<?php

namespace App\Modules\Suppliers\RiskCompliance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Suppliers\RiskCompliance\Database\Factories\ApprovedVendorListFactory;

class ApprovedVendorList extends Model
{
    /** @use HasFactory<ApprovedVendorListFactory> */
    use HasFactory;

    protected $table = 'approved_vendor_lists';

    protected $guarded = [];

    protected static function newFactory(): ApprovedVendorListFactory
    {
        return ApprovedVendorListFactory::new();
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
