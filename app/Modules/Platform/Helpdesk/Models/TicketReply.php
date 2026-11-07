<?php

namespace App\Modules\Platform\Helpdesk\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\Helpdesk\Database\Factories\TicketReplyFactory;

class TicketReply extends Model
{
    use HasFactory;

    protected $table = 'helpdesk_ticket_replies';

    protected $guarded = [];

    protected static function newFactory(): TicketReplyFactory
    {
        return TicketReplyFactory::new();
    }
}
