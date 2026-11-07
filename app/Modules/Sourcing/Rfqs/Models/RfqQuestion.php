<?php

namespace App\Modules\Sourcing\Rfqs\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RfqQuestion extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'rfq_questions';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function askedByOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'asked_by_organization_id');
    }

    public function askedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asked_by_user_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(RfqAnswer::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\Rfqs\Database\Factories\RfqQuestionFactory
    {
        return \App\Modules\Sourcing\Rfqs\Database\Factories\RfqQuestionFactory::new();
    }
}
