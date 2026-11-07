<?php

namespace App\Modules\Sourcing\Bidding\Filament\Buyer\Resources\BidResource\Pages;

use App\Modules\Sourcing\Bidding\Filament\Buyer\Resources\BidResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBids extends ListRecords
{
    protected static string $resource = BidResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
