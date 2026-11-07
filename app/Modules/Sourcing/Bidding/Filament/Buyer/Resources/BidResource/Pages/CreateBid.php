<?php

namespace App\Modules\Sourcing\Bidding\Filament\Buyer\Resources\BidResource\Pages;

use App\Modules\Sourcing\Bidding\Filament\Buyer\Resources\BidResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBid extends CreateRecord
{
    protected static string $resource = BidResource::class;
}
