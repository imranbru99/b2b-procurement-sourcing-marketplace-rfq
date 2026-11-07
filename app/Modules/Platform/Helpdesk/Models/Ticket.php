<?php

namespace App\Modules\Platform\Helpdesk\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\Helpdesk\Database\Factories\TicketFactory;
use App\Models\Concerns\BelongsToOrganization;
use ImranDev\UniversalSlug\Attributes\Slug;
use ImranDev\UniversalSlug\Traits\HasUniversalSlug;

#[Slug(from: 'subject')]
class Ticket extends Model
{
    use HasFactory, BelongsToOrganization, HasUniversalSlug;

    protected $table = 'helpdesk_tickets';

    protected $guarded = [];

    protected static function newFactory(): TicketFactory
    {
        return TicketFactory::new();
    }
}
