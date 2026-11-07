<?php

namespace App\Modules\Core\Users\Filament\Platform\Resources;

use App\Models\User;
use App\Modules\Core\Users\Filament\Concerns\ConfiguresUserResource;
use App\Modules\Core\Users\Filament\Platform\Resources\UserResource\Pages;
use Filament\Resources\Resource;

class UserResource extends Resource
{
    use ConfiguresUserResource;

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Core';

    protected static ?string $navigationLabel = 'Users';

    protected static ?int $navigationSort = 20;

    public static function canAccess(): bool
    {
        return module_enabled('core.users');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
