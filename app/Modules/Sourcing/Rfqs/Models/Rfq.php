<?php

namespace App\Modules\Sourcing\Rfqs\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Sourcing\AwardsContracts\Models\Award;
use App\Modules\Sourcing\Bidding\Models\Bid;
use App\Modules\Sourcing\BidScoring\Models\ScoringCriterion;
use App\Modules\Sourcing\Negotiation\Models\Negotiation;
use App\Modules\Sourcing\PurchaseRequisitions\Models\PurchaseRequisition;
use App\Modules\Sourcing\ReverseAuctions\Models\ReverseAuction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use ImranDev\UniversalSlug\SlugOptions;
use ImranDev\UniversalSlug\Traits\HasUniversalSlug;

class Rfq extends Model
{
    use BelongsToOrganization;
    use HasFactory;
    use HasUniversalSlug;

    protected $table = 'rfqs';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function purchaseRequisition(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequisition::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(RfqItem::class)->orderBy('sort_order');
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(RfqInvitation::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(RfqQuestion::class);
    }

    public function addenda(): HasMany
    {
        return $this->hasMany(RfqAddendum::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function awards(): HasMany
    {
        return $this->hasMany(Award::class);
    }

    public function scoringCriteria(): HasMany
    {
        return $this->hasMany(ScoringCriterion::class);
    }

    public function reverseAuctions(): HasMany
    {
        return $this->hasMany(ReverseAuction::class);
    }

    public function negotiations(): HasMany
    {
        return $this->hasMany(Negotiation::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\Rfqs\Database\Factories\RfqFactory
    {
        return \App\Modules\Sourcing\Rfqs\Database\Factories\RfqFactory::new();
    }
}
