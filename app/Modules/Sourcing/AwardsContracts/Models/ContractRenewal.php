<?php

namespace App\Modules\Sourcing\AwardsContracts\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractRenewal extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'contract_renewals';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'renewal_date' => 'datetime',
            'new_effective_until' => 'datetime',
        ];
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\AwardsContracts\Database\Factories\ContractRenewalFactory
    {
        return \App\Modules\Sourcing\AwardsContracts\Database\Factories\ContractRenewalFactory::new();
    }
}
