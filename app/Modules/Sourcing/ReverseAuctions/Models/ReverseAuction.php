<?php

namespace App\Modules\Sourcing\ReverseAuctions\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReverseAuction extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'reverse_auctions';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'starting_price' => 'decimal:2',
            'current_price' => 'decimal:2',
            'decrement' => 'decimal:2',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function auctionBids(): HasMany
    {
        return $this->hasMany(AuctionBid::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\ReverseAuctions\Database\Factories\ReverseAuctionFactory
    {
        return \App\Modules\Sourcing\ReverseAuctions\Database\Factories\ReverseAuctionFactory::new();
    }
}
