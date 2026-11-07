<?php

namespace App\Modules\Sourcing\Rfqs\Filament\Buyer\Resources\RfqResource\Pages;

use App\Modules\Sourcing\Rfqs\Filament\Buyer\Resources\RfqResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRfq extends ViewRecord
{
    protected static string $resource = RfqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
