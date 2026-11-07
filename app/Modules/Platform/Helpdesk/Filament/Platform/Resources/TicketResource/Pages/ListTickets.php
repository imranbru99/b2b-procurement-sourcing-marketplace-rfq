<?php

namespace App\Modules\Platform\Helpdesk\Filament\Platform\Resources\TicketResource\Pages;

use App\Modules\Platform\Helpdesk\Filament\Platform\Resources\TicketResource;
use Filament\Resources\Pages\ListRecords;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;
}
