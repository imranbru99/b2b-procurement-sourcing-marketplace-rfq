<?php

namespace App\Modules\Sourcing\BidScoring\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\User;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BidEvaluatorAssignment extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'bid_evaluator_assignments';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    protected static function newFactory(): \App\Modules\Sourcing\BidScoring\Database\Factories\BidEvaluatorAssignmentFactory
    {
        return \App\Modules\Sourcing\BidScoring\Database\Factories\BidEvaluatorAssignmentFactory::new();
    }
}
