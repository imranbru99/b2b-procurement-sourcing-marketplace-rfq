<?php

namespace App\Modules\Sourcing\Rfqs\Filament\Buyer\Resources;

use App\Modules\Sourcing\Rfqs\Filament\Buyer\Resources\RfqResource\Pages;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RfqResource extends Resource
{
    protected static ?string $model = Rfq::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Sourcing';

    public static function canAccess(): bool
    {
        return module_enabled('sourcing.rfqs');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('purchase_requisition_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('type')->maxLength(32),
                Forms\Components\TextInput::make('title')->maxLength(255),
                Forms\Components\TextInput::make('slug')->maxLength(255)->unique(ignoreRecord: true),
                Forms\Components\Select::make('visibility')->options(['public' => 'Public', 'private' => 'Private', 'invited' => 'Invited only']),
                Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'open' => 'Open', 'published' => 'Published', 'submitted' => 'Submitted', 'awarded' => 'Awarded', 'closed' => 'Closed', 'cancelled' => 'Cancelled', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'paid' => 'Paid', 'active' => 'Active', 'completed' => 'Completed'])->searchable(),
                Forms\Components\DateTimePicker::make('deadline'),
                Forms\Components\TextInput::make('incoterms')->maxLength(255),
                Forms\Components\TextInput::make('payment_terms')->maxLength(255),
                Forms\Components\TextInput::make('delivery_terms')->maxLength(255),
                Forms\Components\TextInput::make('version')->numeric()->default(1),
                Forms\Components\TextInput::make('parent_id')->numeric()->nullable(),
                Forms\Components\Repeater::make('items')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('description')->required()->maxLength(255),
                        Forms\Components\TextInput::make('quantity')->numeric()->required()->default(1),
                        Forms\Components\TextInput::make('unit')->maxLength(32)->default('ea'),
                        Forms\Components\Textarea::make('specifications')->columnSpanFull(),
                    ])
                    ->columns(3)
                    ->columnSpanFull()
                    ->defaultItems(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('purchase_requisition_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('type')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('visibility')->searchable()->toggleable(),
                Tables\Columns\BadgeColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRfqs::route('/'),
            'create' => Pages\CreateRfq::route('/create'),
            'view' => Pages\ViewRfq::route('/{record}'),
            'edit' => Pages\EditRfq::route('/{record}/edit'),
        ];
    }
}
