<?php

namespace App\Modules\Sourcing\AwardsContracts\Filament\Buyer\Resources\AwardResource\Pages;

use App\Modules\Sourcing\AwardsContracts\Filament\Buyer\Resources\AwardResource;
use Filament\Resources\Pages\ListRecords;

class ListAwards extends ListRecords
{
    protected static string $resource = AwardResource::class;
}
