<?php

namespace App\Modules\Platform\Helpdesk\Filament\Platform\Resources\TicketResource\Pages;

use App\Modules\Platform\Helpdesk\Filament\Platform\Resources\TicketResource;
use Filament\Resources\Pages\EditRecord;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;
}
