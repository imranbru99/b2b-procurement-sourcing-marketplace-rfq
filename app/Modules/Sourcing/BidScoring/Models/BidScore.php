<?php

namespace App\Modules\Sourcing\BidScoring\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\User;
use App\Modules\Sourcing\Bidding\Models\Bid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BidScore extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'bid_scores';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'weighted_score' => 'decimal:4',
        ];
    }

    public function bid(): BelongsTo
    {
        return $this->belongsTo(Bid::class);
    }

    public function criterion(): BelongsTo
    {
        return $this->belongsTo(ScoringCriterion::class, 'scoring_criterion_id');
    }

    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    protected static function newFactory(): \App\Modules\Sourcing\BidScoring\Database\Factories\BidScoreFactory
    {
        return \App\Modules\Sourcing\BidScoring\Database\Factories\BidScoreFactory::new();
    }
}
