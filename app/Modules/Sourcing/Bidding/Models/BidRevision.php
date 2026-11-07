<?php

namespace App\Modules\Sourcing\Bidding\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BidRevision extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'bid_revisions';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
            'snapshot' => 'array',
            'revised_at' => 'datetime',
        ];
    }

    public function bid(): BelongsTo
    {
        return $this->belongsTo(Bid::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\Bidding\Database\Factories\BidRevisionFactory
    {
        return \App\Modules\Sourcing\Bidding\Database\Factories\BidRevisionFactory::new();
    }
}
