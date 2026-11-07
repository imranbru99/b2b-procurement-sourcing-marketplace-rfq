<?php

namespace App\Modules\Suppliers\RiskCompliance\Filament\Buyer\Resources;

use App\Modules\Suppliers\RiskCompliance\Models\RiskScore;
use App\Modules\Suppliers\Support\Filament\BaseSupplierResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class RiskScoreResource extends BaseSupplierResource
{
    protected static ?string $model = RiskScore::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'risk-score-buyer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('supplier_profile_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('score')->numeric(),
                Forms\Components\TextInput::make('risk_band')->maxLength(255),
                Forms\Components\Textarea::make('factors')->columnSpanFull(),
                Forms\Components\DateTimePicker::make('assessed_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('supplier_profile_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('score')->money(fn ($record) => $record->currency ?? 'USD')->sortable(),
                Tables\Columns\TextColumn::make('risk_band')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('factors')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('assessed_at')->dateTime()->sortable(),
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
            'index' => RiskScoreResource\Pages\ListRiskScores::route('/'),
            'create' => RiskScoreResource\Pages\CreateRiskScore::route('/create'),
            'edit' => RiskScoreResource\Pages\EditRiskScore::route('/{record}/edit'),
        ];
    }
}
