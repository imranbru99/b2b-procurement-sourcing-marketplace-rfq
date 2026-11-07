<?php

namespace App\Modules\Sourcing\Negotiation\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NegotiationMessage extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'negotiation_messages';

    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    public function negotiation(): BelongsTo
    {
        return $this->belongsTo(Negotiation::class);
    }

    public function senderUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    public function senderOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'sender_organization_id');
    }

    protected static function newFactory(): \App\Modules\Sourcing\Negotiation\Database\Factories\NegotiationMessageFactory
    {
        return \App\Modules\Sourcing\Negotiation\Database\Factories\NegotiationMessageFactory::new();
    }
}
