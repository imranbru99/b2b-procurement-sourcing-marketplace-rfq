<?php

namespace App\Modules\Core\Organizations\Filament\Admin\Resources;

use App\Models\Organization;
use App\Modules\Core\Organizations\Filament\Concerns\ConfiguresOrganizationResource;
use App\Modules\Core\Organizations\Filament\Admin\Resources\OrganizationResource\Pages;
use App\Modules\Core\Organizations\Filament\Admin\Resources\OrganizationResource\RelationManagers\MembersRelationManager;
use Filament\Resources\Resource;

class OrganizationResource extends Resource
{
    use ConfiguresOrganizationResource;

    protected static ?string $model = Organization::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Core';

    protected static ?string $navigationLabel = 'Organizations';

    protected static ?int $navigationSort = 10;

    protected static ?string $slug = "organizations";

    public static function canAccess(): bool
    {
        return module_enabled('core.organizations');
    }

    public static function getRelations(): array
    {
        return [
            MembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrganizations::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
        ];
    }
}
