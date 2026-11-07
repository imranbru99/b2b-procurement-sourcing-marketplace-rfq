<?php

namespace App\Modules\Orders\GoodsReceipt\Filament\Resources;

use App\Modules\Orders\GoodsReceipt\Filament\Resources\GrnResource\Pages;
use App\Modules\Orders\GoodsReceipt\Models\Grn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GrnResource extends Resource
{
    protected static ?string $model = Grn::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Orders';

    public static function canAccess(): bool
    {
        return module_enabled('orders.goods-receipt');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('purchase_order_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('number')->maxLength(255),
                Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'open' => 'Open', 'published' => 'Published', 'submitted' => 'Submitted', 'awarded' => 'Awarded', 'closed' => 'Closed', 'cancelled' => 'Cancelled', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'paid' => 'Paid', 'active' => 'Active', 'completed' => 'Completed'])->searchable(),
                Forms\Components\DateTimePicker::make('received_at'),
                Forms\Components\TextInput::make('warehouse')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('purchase_order_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('number')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('status'),
                Tables\Columns\TextColumn::make('received_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('warehouse')->searchable()->toggleable(),
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
            'index' => Pages\ListGrns::route('/'),
            'create' => Pages\CreateGrn::route('/create'),
            'edit' => Pages\EditGrn::route('/{record}/edit'),
        ];
    }
}
