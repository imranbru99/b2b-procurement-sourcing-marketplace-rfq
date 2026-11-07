<?php

namespace App\Modules\Suppliers\RiskCompliance\Filament\Platform\Resources\RiskScoreResource\Pages;

use App\Modules\Suppliers\RiskCompliance\Filament\Platform\Resources\RiskScoreResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRiskScore extends CreateRecord
{
    protected static string $resource = RiskScoreResource::class;
}
