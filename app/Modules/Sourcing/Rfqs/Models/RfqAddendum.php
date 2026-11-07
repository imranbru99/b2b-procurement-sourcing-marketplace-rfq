<?php

namespace App\Modules\Sourcing\Rfqs\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RfqAddendum extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'rfq_addenda';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\Rfqs\Database\Factories\RfqAddendumFactory
    {
        return \App\Modules\Sourcing\Rfqs\Database\Factories\RfqAddendumFactory::new();
    }
}
