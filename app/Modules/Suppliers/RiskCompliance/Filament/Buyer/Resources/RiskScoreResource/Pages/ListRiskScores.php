<?php

namespace App\Modules\Suppliers\RiskCompliance\Filament\Buyer\Resources\RiskScoreResource\Pages;

use App\Modules\Suppliers\RiskCompliance\Filament\Buyer\Resources\RiskScoreResource;
use Filament\Resources\Pages\ListRecords;

class ListRiskScores extends ListRecords
{
    protected static string $resource = RiskScoreResource::class;
}
