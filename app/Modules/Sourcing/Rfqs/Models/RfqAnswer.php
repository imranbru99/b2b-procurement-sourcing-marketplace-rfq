<?php

namespace App\Modules\Sourcing\Rfqs\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RfqAnswer extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'rfq_answers';

    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(RfqQuestion::class, 'rfq_question_id');
    }

    public function answeredByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'answered_by_user_id');
    }

    protected static function newFactory(): \App\Modules\Sourcing\Rfqs\Database\Factories\RfqAnswerFactory
    {
        return \App\Modules\Sourcing\Rfqs\Database\Factories\RfqAnswerFactory::new();
    }
}
