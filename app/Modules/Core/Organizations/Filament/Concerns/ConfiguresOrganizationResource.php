<?php

namespace App\Modules\Core\Organizations\Filament\Concerns;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

trait ConfiguresOrganizationResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(function (Forms\Set $set, ?string $state, ?string $old, Forms\Get $get): void {
                    if (! $get('slug') || $get('slug') === Str::slug((string) $old)) {
                        $set('slug', Str::slug((string) $state));
                    }
                }),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),
            Forms\Components\Select::make('type')
                ->options([
                    'buyer' => 'Buyer',
                    'supplier' => 'Supplier',
                    'both' => 'Both',
                    'logistics' => 'Logistics',
                ])
                ->required()
                ->native(false),
            Forms\Components\TextInput::make('country')
                ->maxLength(2)
                ->placeholder('BD'),
            Forms\Components\TextInput::make('timezone')
                ->required()
                ->default('UTC')
                ->maxLength(64),
            Forms\Components\TextInput::make('currency')
                ->required()
                ->default('USD')
                ->maxLength(3)
                ->dehydrateStateUsing(fn (?string $state): string => strtoupper((string) ($state ?: 'USD')))
                ->afterStateHydrated(function (Forms\Components\TextInput $component, $record): void {
                    if ($record) {
                        $component->state($record->currency);
                    }
                }),
            Forms\Components\Select::make('status')
                ->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ])
                ->required()
                ->default('active')
                ->native(false)
                ->dehydrateStateUsing(fn (?string $state): string => $state ?: 'active')
                ->afterStateHydrated(function (Forms\Components\Select $component, $record): void {
                    if ($record) {
                        $component->state($record->status);
                    }
                }),
            Forms\Components\TextInput::make('locale')
                ->maxLength(12)
                ->default('en'),
            Forms\Components\TextInput::make('email')->email()->maxLength(255),
            Forms\Components\TextInput::make('phone')->tel()->maxLength(50),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable()->toggleable(),
                Tables\Columns\BadgeColumn::make('type'),
                Tables\Columns\TextColumn::make('country')->toggleable(),
                Tables\Columns\TextColumn::make('timezone')->toggleable(),
                Tables\Columns\TextColumn::make('currency'),
                Tables\Columns\BadgeColumn::make('status'),
                Tables\Columns\TextColumn::make('users_count')->counts('users')->label('Members'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
