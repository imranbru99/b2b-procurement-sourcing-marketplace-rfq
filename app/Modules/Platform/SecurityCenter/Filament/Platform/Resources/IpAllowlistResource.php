<?php

namespace App\Modules\Platform\SecurityCenter\Filament\Platform\Resources;

use App\Modules\Platform\SecurityCenter\Models\IpAllowlist;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class IpAllowlistResource extends BasePlatformResource
{
    protected static ?string $model = IpAllowlist::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Security Center';

    public static function canAccess(): bool
    {
        return module_enabled('platform.security-center');
    }
    protected static ?string $slug = 'platform-ip-allowlist';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('cidr')->maxLength(255),
                Forms\Components\TextInput::make('label')->maxLength(255),
                Forms\Components\Toggle::make('is_active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('cidr')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('label')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('is_active')->searchable()->toggleable(),
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
            'index' => IpAllowlistResource\Pages\ListIpAllowlists::route('/'),
            'create' => IpAllowlistResource\Pages\CreateIpAllowlist::route('/create'),
            'edit' => IpAllowlistResource\Pages\EditIpAllowlist::route('/{record}/edit'),
        ];
    }
}
