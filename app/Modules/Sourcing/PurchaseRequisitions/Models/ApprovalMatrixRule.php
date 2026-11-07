<?php

namespace App\Modules\Sourcing\PurchaseRequisitions\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalMatrixRule extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'approval_matrix_rules';

    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    protected static function newFactory(): \App\Modules\Sourcing\PurchaseRequisitions\Database\Factories\ApprovalMatrixRuleFactory
    {
        return \App\Modules\Sourcing\PurchaseRequisitions\Database\Factories\ApprovalMatrixRuleFactory::new();
    }
}
