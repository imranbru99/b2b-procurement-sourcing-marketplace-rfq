<?php

namespace App\Modules\Sourcing\Negotiation\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CounterOffer extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'counter_offers';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'expires_at' => 'datetime',
        ];
    }

    public function negotiation(): BelongsTo
    {
        return $this->belongsTo(Negotiation::class);
    }

    public function offeredByOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'offered_by_organization_id');
    }

    protected static function newFactory(): \App\Modules\Sourcing\Negotiation\Database\Factories\CounterOfferFactory
    {
        return \App\Modules\Sourcing\Negotiation\Database\Factories\CounterOfferFactory::new();
    }
}
