<?php

namespace App\Modules\Sourcing\Rfqs\Filament\Buyer\Resources\RfqResource\Pages;

use App\Modules\Sourcing\Rfqs\Filament\Buyer\Resources\RfqResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRfq extends EditRecord
{
    protected static string $resource = RfqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
