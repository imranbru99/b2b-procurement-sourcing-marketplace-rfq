<?php

namespace App\Modules\Suppliers\KycOnboarding\Filament\Buyer\Resources\KycApplicationResource\Pages;

use App\Modules\Suppliers\KycOnboarding\Filament\Buyer\Resources\KycApplicationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKycApplication extends CreateRecord
{
    protected static string $resource = KycApplicationResource::class;
}
