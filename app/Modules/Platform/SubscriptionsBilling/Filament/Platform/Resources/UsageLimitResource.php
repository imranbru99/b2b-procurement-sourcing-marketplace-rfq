<?php

namespace App\Modules\Platform\SubscriptionsBilling\Filament\Platform\Resources;

use App\Modules\Platform\SubscriptionsBilling\Models\UsageLimit;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class UsageLimitResource extends BasePlatformResource
{
    protected static ?string $model = UsageLimit::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Subscriptions';

    public static function canAccess(): bool
    {
        return module_enabled('platform.subscriptions-billing');
    }
    protected static ?string $slug = 'platform-usage-limit';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('metric')->maxLength(255),
                Forms\Components\TextInput::make('limit_value')->numeric(),
                Forms\Components\TextInput::make('current_value')->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('metric')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('limit_value')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('current_value')->searchable()->toggleable(),
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
            'index' => UsageLimitResource\Pages\ListUsageLimits::route('/'),
            'create' => UsageLimitResource\Pages\CreateUsageLimit::route('/create'),
            'edit' => UsageLimitResource\Pages\EditUsageLimit::route('/{record}/edit'),
        ];
    }
}
