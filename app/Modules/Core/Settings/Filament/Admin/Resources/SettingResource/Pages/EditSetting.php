<?php

namespace App\Modules\Core\Settings\Filament\Admin\Resources\SettingResource\Pages;

use App\Modules\Core\Settings\Filament\Admin\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
