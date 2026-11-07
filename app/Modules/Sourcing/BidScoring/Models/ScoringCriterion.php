<?php

namespace App\Modules\Sourcing\BidScoring\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScoringCriterion extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'scoring_criteria';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'weight' => 'decimal:4',
            'max_score' => 'decimal:2',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(BidScore::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\BidScoring\Database\Factories\ScoringCriterionFactory
    {
        return \App\Modules\Sourcing\BidScoring\Database\Factories\ScoringCriterionFactory::new();
    }
}
