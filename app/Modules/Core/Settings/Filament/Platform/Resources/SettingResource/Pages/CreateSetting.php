<?php

namespace App\Modules\Core\Settings\Filament\Platform\Resources\SettingResource\Pages;

use App\Modules\Core\Settings\Filament\Platform\Resources\SettingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSetting extends CreateRecord
{
    protected static string $resource = SettingResource::class;
}
