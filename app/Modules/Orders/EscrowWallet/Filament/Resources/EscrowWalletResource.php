<?php

namespace App\Modules\Orders\EscrowWallet\Filament\Resources;

use App\Modules\Orders\EscrowWallet\Filament\Resources\EscrowWalletResource\Pages;
use App\Modules\Orders\EscrowWallet\Models\EscrowWallet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EscrowWalletResource extends Resource
{
    protected static ?string $model = EscrowWallet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Orders';

    public static function canAccess(): bool
    {
        return module_enabled('orders.escrow-wallet');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('purchase_order_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('currency')->maxLength(3)->default('USD'),
                Forms\Components\TextInput::make('balance')->numeric(),
                Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'open' => 'Open', 'published' => 'Published', 'submitted' => 'Submitted', 'awarded' => 'Awarded', 'closed' => 'Closed', 'cancelled' => 'Cancelled', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'paid' => 'Paid', 'active' => 'Active', 'completed' => 'Completed'])->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('purchase_order_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('currency')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('balance')->money(fn ($record) => $record->currency ?? 'USD')->sortable(),
                Tables\Columns\BadgeColumn::make('status'),
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
            'index' => Pages\ListEscrowWallets::route('/'),
            'create' => Pages\CreateEscrowWallet::route('/create'),
            'edit' => Pages\EditEscrowWallet::route('/{record}/edit'),
        ];
    }
}
