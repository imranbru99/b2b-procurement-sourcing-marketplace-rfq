<?php

namespace App\Modules\Intelligence\AnalyticsReporting\Filament\Resources;

use App\Modules\Intelligence\AnalyticsReporting\Filament\Resources\SavedReportResource\Pages;
use App\Modules\Intelligence\AnalyticsReporting\Models\SavedReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SavedReportResource extends Resource
{
    protected static ?string $model = SavedReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $navigationGroup = 'Intelligence';

    public static function canAccess(): bool
    {
        return module_enabled('intelligence.analytics');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('created_by')->numeric(),
                Forms\Components\TextInput::make('name')->maxLength(255),
                Forms\Components\TextInput::make('type')->maxLength(32),
                Forms\Components\Textarea::make('filters')->columnSpanFull(),
                Forms\Components\Textarea::make('layout')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('created_by')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('filters')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('layout')->searchable()->toggleable(),
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
            'index' => Pages\ListSavedReports::route('/'),
            'create' => Pages\CreateSavedReport::route('/create'),
            'edit' => Pages\EditSavedReport::route('/{record}/edit'),
        ];
    }
}
