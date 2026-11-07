<?php

namespace App\Modules\Intelligence\AnalyticsReporting\Filament\Resources\SavedReportResource\Pages;

use App\Modules\Intelligence\AnalyticsReporting\Filament\Resources\SavedReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSavedReports extends ListRecords
{
    protected static string $resource = SavedReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
