<?php

namespace App\Modules\Core\Settings\Filament\Concerns;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

trait ConfiguresSettingResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('organization_id')
                ->relationship('organization', 'name')
                ->searchable()
                ->preload()
                ->nullable()
                ->helperText('Leave empty for platform-wide defaults.'),
            Forms\Components\TextInput::make('group')
                ->required()
                ->maxLength(100)
                ->default('general'),
            Forms\Components\TextInput::make('key')
                ->required()
                ->maxLength(150),
            Forms\Components\KeyValue::make('value')
                ->nullable()
                ->columnSpanFull(),
            Forms\Components\Toggle::make('is_locked')
                ->default(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('organization.name')
                    ->label('Organization')
                    ->placeholder('Platform')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('group')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('key')->searchable()->sortable(),
                Tables\Columns\IconColumn::make('is_locked')->boolean(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
