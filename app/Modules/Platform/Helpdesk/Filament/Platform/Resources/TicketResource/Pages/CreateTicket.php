<?php

namespace App\Modules\Platform\Helpdesk\Filament\Platform\Resources\TicketResource\Pages;

use App\Modules\Platform\Helpdesk\Filament\Platform\Resources\TicketResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;
}
