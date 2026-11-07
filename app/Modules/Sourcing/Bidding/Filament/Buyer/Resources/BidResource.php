<?php

namespace App\Modules\Sourcing\Bidding\Filament\Buyer\Resources;

use App\Modules\Sourcing\Bidding\Filament\Buyer\Resources\BidResource\Pages;
use App\Modules\Sourcing\Bidding\Models\Bid;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BidResource extends Resource
{
    protected static ?string $model = Bid::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Sourcing';

    protected static ?string $navigationLabel = 'Bids';

    public static function canAccess(): bool
    {
        return module_enabled('sourcing.bidding');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
            Forms\Components\Select::make('rfq_id')->relationship('rfq', 'title')->searchable()->required(),
            Forms\Components\TextInput::make('supplier_organization_id')->numeric()->required(),
            Forms\Components\Select::make('status')->options([
                'draft' => 'Draft',
                'submitted' => 'Submitted',
                'withdrawn' => 'Withdrawn',
                'awarded' => 'Awarded',
                'rejected' => 'Rejected',
            ])->required(),
            Forms\Components\TextInput::make('total')->numeric()->required(),
            Forms\Components\TextInput::make('currency')->maxLength(3)->default('USD'),
            Forms\Components\TextInput::make('lead_time_days')->numeric(),
            Forms\Components\DateTimePicker::make('valid_until'),
            Forms\Components\Toggle::make('is_sealed'),
            Forms\Components\DateTimePicker::make('submitted_at'),
            Forms\Components\Repeater::make('items')
                ->relationship()
                ->schema([
                    Forms\Components\TextInput::make('rfq_item_id')->numeric(),
                    Forms\Components\TextInput::make('quantity')->numeric()->default(1),
                    Forms\Components\TextInput::make('unit_price')->numeric()->required(),
                    Forms\Components\TextInput::make('line_total')->numeric(),
                ])
                ->columns(4)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('rfq.title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('supplier_organization_id')->toggleable(),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('total')->money(fn ($record) => $record->currency ?? 'USD'),
                Tables\Columns\TextColumn::make('lead_time_days'),
                Tables\Columns\IconColumn::make('is_sealed')->boolean(),
                Tables\Columns\TextColumn::make('submitted_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBids::route('/'),
            'create' => Pages\CreateBid::route('/create'),
            'view' => Pages\ViewBid::route('/{record}'),
            'edit' => Pages\EditBid::route('/{record}/edit'),
        ];
    }
}
