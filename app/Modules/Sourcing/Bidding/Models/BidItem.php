<?php

namespace App\Modules\Sourcing\Bidding\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Sourcing\Rfqs\Models\RfqItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BidItem extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'bid_items';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:4',
            'unit_price' => 'decimal:2',
            'line_total' => 'decimal:2',
        ];
    }

    public function bid(): BelongsTo
    {
        return $this->belongsTo(Bid::class);
    }

    public function rfqItem(): BelongsTo
    {
        return $this->belongsTo(RfqItem::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\Bidding\Database\Factories\BidItemFactory
    {
        return \App\Modules\Sourcing\Bidding\Database\Factories\BidItemFactory::new();
    }
}
