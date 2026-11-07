<?php

namespace App\Modules\Platform\SecurityCenter\Filament\Platform\Resources;

use App\Modules\Platform\SecurityCenter\Models\SecuritySetting;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class SecuritySettingResource extends BasePlatformResource
{
    protected static ?string $model = SecuritySetting::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Security Center';

    public static function canAccess(): bool
    {
        return module_enabled('platform.security-center');
    }
    protected static ?string $slug = 'platform-security-setting';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\Textarea::make('settings')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('settings')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => SecuritySettingResource\Pages\ListSecuritySettings::route('/'),
            'create' => SecuritySettingResource\Pages\CreateSecuritySetting::route('/create'),
            'edit' => SecuritySettingResource\Pages\EditSecuritySetting::route('/{record}/edit'),
        ];
    }
}
