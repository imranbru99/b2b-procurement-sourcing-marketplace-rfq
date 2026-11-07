<?php

namespace App\Modules\Suppliers\KycOnboarding\Filament\Platform\Resources\KycApplicationResource\Pages;

use App\Modules\Suppliers\KycOnboarding\Filament\Platform\Resources\KycApplicationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKycApplication extends CreateRecord
{
    protected static string $resource = KycApplicationResource::class;
}
