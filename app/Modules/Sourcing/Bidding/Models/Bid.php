<?php

namespace App\Modules\Sourcing\Bidding\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use App\Modules\Sourcing\AwardsContracts\Models\Award;
use App\Modules\Sourcing\BidScoring\Models\BidScore;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bid extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'bids';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'valid_until' => 'datetime',
            'submitted_at' => 'datetime',
            'is_sealed' => 'boolean',
            'total' => 'decimal:2',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function supplierOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'supplier_organization_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(BidItem::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(BidRevision::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(BidScore::class);
    }

    public function awards(): HasMany
    {
        return $this->hasMany(Award::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\Bidding\Database\Factories\BidFactory
    {
        return \App\Modules\Sourcing\Bidding\Database\Factories\BidFactory::new();
    }
}
