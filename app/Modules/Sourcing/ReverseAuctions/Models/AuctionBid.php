<?php

namespace App\Modules\Sourcing\ReverseAuctions\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuctionBid extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'auction_bids';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'is_winning' => 'boolean',
            'placed_at' => 'datetime',
        ];
    }

    public function reverseAuction(): BelongsTo
    {
        return $this->belongsTo(ReverseAuction::class);
    }

    public function supplierOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'supplier_organization_id');
    }

    protected static function newFactory(): \App\Modules\Sourcing\ReverseAuctions\Database\Factories\AuctionBidFactory
    {
        return \App\Modules\Sourcing\ReverseAuctions\Database\Factories\AuctionBidFactory::new();
    }
}
