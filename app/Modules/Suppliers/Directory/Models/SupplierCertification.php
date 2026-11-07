<?php

namespace App\Modules\Suppliers\Directory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Suppliers\Directory\Database\Factories\SupplierCertificationFactory;

class SupplierCertification extends Model
{
    /** @use HasFactory<SupplierCertificationFactory> */
    use HasFactory;

    protected $table = 'supplier_certifications';

    protected $guarded = [];

    protected static function newFactory(): SupplierCertificationFactory
    {
        return SupplierCertificationFactory::new();
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
