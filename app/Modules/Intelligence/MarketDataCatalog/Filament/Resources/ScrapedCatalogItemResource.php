<?php

namespace App\Modules\Intelligence\MarketDataCatalog\Filament\Resources;

use App\Modules\Intelligence\MarketDataCatalog\Filament\Resources\ScrapedCatalogItemResource\Pages;
use App\Modules\Intelligence\MarketDataCatalog\Models\ScrapedCatalogItem;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ScrapedCatalogItemResource extends Resource
{
    protected static ?string $model = ScrapedCatalogItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Intelligence';

    protected static ?string $navigationLabel = 'Market catalog';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->limit(40),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('price')->money(fn (ScrapedCatalogItem $record) => $record->currency),
                Tables\Columns\TextColumn::make('source_url')->limit(30)->toggleable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListScrapedCatalogItems::route('/'),
        ];
    }
}
