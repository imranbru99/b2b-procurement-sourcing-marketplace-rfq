<?php

namespace App\Modules\Platform\SecurityCenter\Filament\Platform\Resources;

use App\Modules\Platform\SecurityCenter\Models\UserSessionTracking;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class UserSessionTrackingResource extends BasePlatformResource
{
    protected static ?string $model = UserSessionTracking::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Security Center';

    public static function canAccess(): bool
    {
        return module_enabled('platform.security-center');
    }
    protected static ?string $slug = 'platform-user-session-tracking';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('ip')->maxLength(255),
                Forms\Components\Textarea::make('user_agent')->columnSpanFull(),
                Forms\Components\DateTimePicker::make('last_activity_at'),
                Forms\Components\DateTimePicker::make('logged_out_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('user_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('ip')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('user_agent')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('last_activity_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('logged_out_at')->dateTime()->sortable(),
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
            'index' => UserSessionTrackingResource\Pages\ListUserSessionTrackings::route('/'),
            'create' => UserSessionTrackingResource\Pages\CreateUserSessionTracking::route('/create'),
            'edit' => UserSessionTrackingResource\Pages\EditUserSessionTracking::route('/{record}/edit'),
        ];
    }
}
