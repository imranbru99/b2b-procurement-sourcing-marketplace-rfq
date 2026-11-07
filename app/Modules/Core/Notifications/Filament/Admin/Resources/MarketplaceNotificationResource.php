<?php

namespace App\Modules\Core\Notifications\Filament\Admin\Resources;

use App\Modules\Core\Notifications\Filament\Admin\Resources\MarketplaceNotificationResource\Pages;
use App\Modules\Core\Notifications\Models\MarketplaceNotification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MarketplaceNotificationResource extends Resource
{
    protected static ?string $model = MarketplaceNotification::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell';

    protected static ?string $navigationGroup = 'Core';

    protected static ?string $navigationLabel = 'Notifications';

    protected static ?int $navigationSort = 50;

    protected static ?string $slug = "marketplace-notifications";

    public static function canAccess(): bool
    {
        return module_enabled('core.notifications');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('type')->required()->maxLength(100),
            Forms\Components\Select::make('organization_id')
                ->relationship('organization', 'name')
                ->searchable()
                ->preload()
                ->nullable(),
            Forms\Components\KeyValue::make('data')->columnSpanFull(),
            Forms\Components\DateTimePicker::make('read_at')->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('organization.name')->placeholder('—')->toggleable(),
                Tables\Columns\TextColumn::make('notifiable_type')->label('Notifiable')->toggleable(),
                Tables\Columns\TextColumn::make('data.title')->label('Title')->limit(40),
                Tables\Columns\IconColumn::make('read_at')
                    ->label('Read')
                    ->boolean()
                    ->getStateUsing(fn (MarketplaceNotification $record): bool => $record->read_at !== null),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMarketplaceNotifications::route('/'),
            'view' => Pages\ViewMarketplaceNotification::route('/{record}'),
        ];
    }
}
