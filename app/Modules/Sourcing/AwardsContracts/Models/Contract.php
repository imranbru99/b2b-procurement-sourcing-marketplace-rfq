<?php

namespace App\Modules\Sourcing\AwardsContracts\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use ImranDev\UniversalSlug\SlugOptions;
use ImranDev\UniversalSlug\Traits\HasUniversalSlug;

class Contract extends Model
{
    use BelongsToOrganization;
    use HasFactory;
    use HasUniversalSlug;

    protected $table = 'contracts';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'signed_at' => 'datetime',
            'effective_from' => 'datetime',
            'effective_until' => 'datetime',
            'contract_value' => 'decimal:2',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function award(): BelongsTo
    {
        return $this->belongsTo(Award::class);
    }

    public function supplierOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'supplier_organization_id');
    }

    public function clauses(): HasMany
    {
        return $this->hasMany(ContractClause::class)->orderBy('sort_order');
    }

    public function renewals(): HasMany
    {
        return $this->hasMany(ContractRenewal::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\AwardsContracts\Database\Factories\ContractFactory
    {
        return \App\Modules\Sourcing\AwardsContracts\Database\Factories\ContractFactory::new();
    }
}
