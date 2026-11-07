<?php

namespace App\Modules\Sourcing\Bidding\Filament\Buyer\Resources\BidResource\Pages;

use App\Modules\Sourcing\Bidding\Filament\Buyer\Resources\BidResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBid extends EditRecord
{
    protected static string $resource = BidResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
