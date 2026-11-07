<?php

namespace App\Modules\Suppliers\KycOnboarding\Filament\Platform\Resources\KycApplicationResource\Pages;

use App\Modules\Suppliers\KycOnboarding\Filament\Platform\Resources\KycApplicationResource;
use Filament\Resources\Pages\ListRecords;

class ListKycApplications extends ListRecords
{
    protected static string $resource = KycApplicationResource::class;
}
