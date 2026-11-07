<?php

namespace App\Modules\Core\Settings\Filament\Admin\Resources;

use App\Modules\Core\Settings\Filament\Admin\Resources\SettingResource\Pages;
use App\Modules\Core\Settings\Filament\Concerns\ConfiguresSettingResource;
use App\Modules\Core\Settings\Models\Setting;
use Filament\Resources\Resource;

class SettingResource extends Resource
{
    use ConfiguresSettingResource;

    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Core';

    protected static ?string $navigationLabel = 'Settings';

    protected static ?int $navigationSort = 40;

    protected static ?string $slug = 'settings';

    public static function canAccess(): bool
    {
        return module_enabled('core.settings');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
