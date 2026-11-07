<?php

namespace App\Modules\Intelligence\AiAssistant\Filament\Resources;

use App\Modules\Intelligence\AiAssistant\Filament\Resources\AiUsageLogResource\Pages;
use App\Modules\Intelligence\AiAssistant\Models\AiUsageLog;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AiUsageLogResource extends Resource
{
    protected static ?string $model = AiUsageLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    protected static ?string $navigationGroup = 'Intelligence';

    protected static ?string $navigationLabel = 'AI usage';

    protected static ?int $navigationSort = 20;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('feature')->badge()->searchable(),
                Tables\Columns\TextColumn::make('provider')->toggleable(),
                Tables\Columns\TextColumn::make('model')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('tokens_in')->numeric(),
                Tables\Columns\TextColumn::make('tokens_out')->numeric(),
                Tables\Columns\TextColumn::make('cost_usd')->money('usd'),
                Tables\Columns\TextColumn::make('user.name')->label('User')->toggleable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAiUsageLogs::route('/'),
        ];
    }
}
