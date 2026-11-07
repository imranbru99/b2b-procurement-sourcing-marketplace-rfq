<?php

namespace App\Modules\Intelligence\AnalyticsReporting\Filament\Resources\SavedReportResource\Pages;

use App\Modules\Intelligence\AnalyticsReporting\Filament\Resources\SavedReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSavedReport extends EditRecord
{
    protected static string $resource = SavedReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
