<?php

namespace App\Modules\Sourcing\AwardsContracts\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractClause extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'contract_clauses';

    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\AwardsContracts\Database\Factories\ContractClauseFactory
    {
        return \App\Modules\Sourcing\AwardsContracts\Database\Factories\ContractClauseFactory::new();
    }
}
