<?php

namespace App\Modules\Suppliers\KycOnboarding\Filament\Buyer\Resources\KycApplicationResource\Pages;

use App\Modules\Suppliers\KycOnboarding\Filament\Buyer\Resources\KycApplicationResource;
use Filament\Resources\Pages\EditRecord;

class EditKycApplication extends EditRecord
{
    protected static string $resource = KycApplicationResource::class;
}
