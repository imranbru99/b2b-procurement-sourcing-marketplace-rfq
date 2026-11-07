<?php

namespace App\Modules\Sourcing\Rfqs\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RfqItem extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'rfq_items';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:4',
            'estimated_unit_price' => 'decimal:2',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\Rfqs\Database\Factories\RfqItemFactory
    {
        return \App\Modules\Sourcing\Rfqs\Database\Factories\RfqItemFactory::new();
    }
}
