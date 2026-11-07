<?php

namespace App\Modules\Platform\SubscriptionsBilling\Filament\Platform\Resources;

use App\Modules\Platform\SubscriptionsBilling\Models\PlanPrice;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class PlanPriceResource extends BasePlatformResource
{
    protected static ?string $model = PlanPrice::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Subscriptions';

    public static function canAccess(): bool
    {
        return module_enabled('platform.subscriptions-billing');
    }
    protected static ?string $slug = 'platform-plan-price';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('plan_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('currency')->maxLength(3)->default('USD'),
                Forms\Components\TextInput::make('amount')->numeric(),
                Forms\Components\TextInput::make('interval')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('plan_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('currency')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('amount')->money(fn ($record) => $record->currency ?? 'USD')->sortable(),
                Tables\Columns\TextColumn::make('interval')->searchable()->toggleable(),
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
            'index' => PlanPriceResource\Pages\ListPlanPrices::route('/'),
            'create' => PlanPriceResource\Pages\CreatePlanPrice::route('/create'),
            'edit' => PlanPriceResource\Pages\EditPlanPrice::route('/{record}/edit'),
        ];
    }
}
