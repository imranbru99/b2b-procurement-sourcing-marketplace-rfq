<?php

namespace App\Modules\Sourcing\PurchaseRequisitions\Filament\Buyer\Resources;

use App\Modules\Sourcing\PurchaseRequisitions\Filament\Buyer\Resources\PurchaseRequisitionResource\Pages\ListPurchaseRequisitions;
use App\Modules\Sourcing\PurchaseRequisitions\Models\PurchaseRequisition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PurchaseRequisitionResource extends Resource
{
    protected static ?string $model = PurchaseRequisition::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Sourcing';

    public static function canAccess(): bool
    {
        return module_enabled('sourcing.purchase-requisitions');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('department')->maxLength(255),
                Forms\Components\TextInput::make('requester_id')->numeric()->nullable(),
                Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'open' => 'Open', 'published' => 'Published', 'submitted' => 'Submitted', 'awarded' => 'Awarded', 'closed' => 'Closed', 'cancelled' => 'Cancelled', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'paid' => 'Paid', 'active' => 'Active', 'completed' => 'Completed'])->searchable(),
                Forms\Components\TextInput::make('amount')->numeric(),
                Forms\Components\TextInput::make('currency')->maxLength(3)->default('USD'),
                Forms\Components\TextInput::make('budget_code')->maxLength(255),
                Forms\Components\TextInput::make('approval_level')->maxLength(255),
                Forms\Components\Textarea::make('notes')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('department')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('requester_id')->searchable()->toggleable(),
                Tables\Columns\BadgeColumn::make('status'),
                Tables\Columns\TextColumn::make('amount')->money(fn ($record) => $record->currency ?? 'USD')->sortable(),
                Tables\Columns\TextColumn::make('currency')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('budget_code')->searchable()->toggleable(),
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
            'index' => ListPurchaseRequisitions::route('/'),
        ];
    }
}
