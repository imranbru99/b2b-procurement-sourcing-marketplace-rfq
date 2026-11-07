<?php

namespace App\Modules\Platform\SubscriptionsBilling\Filament\Platform\Resources;

use App\Modules\Platform\SubscriptionsBilling\Models\Plan;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class PlanResource extends BasePlatformResource
{
    protected static ?string $model = Plan::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Subscriptions';

    public static function canAccess(): bool
    {
        return module_enabled('platform.subscriptions-billing');
    }
    protected static ?string $slug = 'platform-plan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->maxLength(255),
                Forms\Components\TextInput::make('slug')->maxLength(255)->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('modules')->columnSpanFull(),
                Forms\Components\Toggle::make('is_active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('modules')->searchable()->toggleable(),
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
            'index' => PlanResource\Pages\ListPlans::route('/'),
            'create' => PlanResource\Pages\CreatePlan::route('/create'),
            'edit' => PlanResource\Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
