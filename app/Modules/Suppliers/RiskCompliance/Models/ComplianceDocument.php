<?php

namespace App\Modules\Suppliers\RiskCompliance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Modules\Suppliers\RiskCompliance\Database\Factories\ComplianceDocumentFactory;

class ComplianceDocument extends Model implements HasMedia
{
    /** @use HasFactory<ComplianceDocumentFactory> */
    use HasFactory, InteractsWithMedia;

    protected $table = 'compliance_documents';

    protected $guarded = [];

    protected static function newFactory(): ComplianceDocumentFactory
    {
        return ComplianceDocumentFactory::new();
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
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')->useDisk(config('filesystems.default'));
    }

}
