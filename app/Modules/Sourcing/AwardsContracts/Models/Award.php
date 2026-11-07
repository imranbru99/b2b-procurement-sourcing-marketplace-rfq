<?php

namespace App\Modules\Sourcing\AwardsContracts\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use App\Modules\Sourcing\Bidding\Models\Bid;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Award extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'awards';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'awarded_amount' => 'decimal:2',
            'award_percentage' => 'decimal:4',
            'awarded_at' => 'datetime',
        ];
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

    public function contract(): HasOne
    {
        return $this->hasOne(Contract::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\AwardsContracts\Database\Factories\AwardFactory
    {
        return \App\Modules\Sourcing\AwardsContracts\Database\Factories\AwardFactory::new();
    }
}
