<?php

namespace App\Modules\Platform\SubscriptionsBilling\Filament\Platform\Resources;

use App\Modules\Platform\SubscriptionsBilling\Models\CouponPlatform;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class CouponPlatformResource extends BasePlatformResource
{
    protected static ?string $model = CouponPlatform::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Subscriptions';

    public static function canAccess(): bool
    {
        return module_enabled('platform.subscriptions-billing');
    }
    protected static ?string $slug = 'platform-coupon-platform';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')->maxLength(255),
                Forms\Components\TextInput::make('discount_percent')->maxLength(255),
                Forms\Components\TextInput::make('discount_amount')->numeric(),
                Forms\Components\TextInput::make('max_uses')->maxLength(255),
                Forms\Components\DateTimePicker::make('expires_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('code')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('discount_percent')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('discount_amount')->money(fn ($record) => $record->currency ?? 'USD')->sortable(),
                Tables\Columns\TextColumn::make('max_uses')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('expires_at')->dateTime()->sortable(),
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
            'index' => CouponPlatformResource\Pages\ListCouponPlatforms::route('/'),
            'create' => CouponPlatformResource\Pages\CreateCouponPlatform::route('/create'),
            'edit' => CouponPlatformResource\Pages\EditCouponPlatform::route('/{record}/edit'),
        ];
    }
}
