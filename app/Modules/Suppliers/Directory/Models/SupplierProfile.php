<?php

namespace App\Modules\Suppliers\Directory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;
use ImranDev\UniversalSlug\Attributes\Slug;
use ImranDev\UniversalSlug\Traits\HasUniversalSlug;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Modules\Suppliers\Directory\Database\Factories\SupplierProfileFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Slug(from: 'company_name')]
class SupplierProfile extends Model implements HasMedia
{
    /** @use HasFactory<SupplierProfileFactory> */
    use HasFactory, BelongsToOrganization, HasUniversalSlug, InteractsWithMedia;

    protected $table = 'supplier_profiles';

    protected $guarded = [];

    protected static function newFactory(): SupplierProfileFactory
    {
        return SupplierProfileFactory::new();
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
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            SupplierCategory::class,
            'category_supplier',
            'supplier_profile_id',
            'supplier_category_id'
        )->withPivot('is_primary')->withTimestamps();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
        $this->addMediaCollection('gallery');
    }

}
