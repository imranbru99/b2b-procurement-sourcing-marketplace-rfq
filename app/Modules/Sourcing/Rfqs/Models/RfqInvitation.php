<?php

namespace App\Modules\Sourcing\Rfqs\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RfqInvitation extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'rfq_invitations';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
            'responded_at' => 'datetime',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function supplierOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'supplier_organization_id');
    }

    protected static function newFactory(): \App\Modules\Sourcing\Rfqs\Database\Factories\RfqInvitationFactory
    {
        return \App\Modules\Sourcing\Rfqs\Database\Factories\RfqInvitationFactory::new();
    }
}
