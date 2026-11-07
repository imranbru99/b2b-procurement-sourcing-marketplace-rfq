<?php

namespace App\Modules\Suppliers\KycOnboarding\Filament\Supplier\Resources\KycApplicationResource\Pages;

use App\Modules\Suppliers\KycOnboarding\Filament\Supplier\Resources\KycApplicationResource;
use Filament\Resources\Pages\ListRecords;

class ListKycApplications extends ListRecords
{
    protected static string $resource = KycApplicationResource::class;
}
