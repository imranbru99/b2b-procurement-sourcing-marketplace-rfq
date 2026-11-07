<?php

namespace App\Modules\Sourcing\Negotiation\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use App\Modules\Sourcing\Bidding\Models\Bid;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Negotiation extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'negotiations';

    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function bid(): BelongsTo
    {
        return $this->belongsTo(Bid::class);
    }

    public function supplierOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'supplier_organization_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(NegotiationMessage::class);
    }

    public function counterOffers(): HasMany
    {
        return $this->hasMany(CounterOffer::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\Negotiation\Database\Factories\NegotiationFactory
    {
        return \App\Modules\Sourcing\Negotiation\Database\Factories\NegotiationFactory::new();
    }
}
