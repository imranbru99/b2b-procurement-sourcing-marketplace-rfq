<?php

namespace App\Modules\Sourcing\AwardsContracts\Filament\Buyer\Resources;

use App\Modules\Sourcing\AwardsContracts\Filament\Buyer\Resources\AwardResource\Pages\ListAwards;
use App\Modules\Sourcing\AwardsContracts\Models\Award;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AwardResource extends Resource
{
    protected static ?string $model = Award::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'Sourcing';

    public static function canAccess(): bool
    {
        return module_enabled('sourcing.awards-contracts');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('rfq_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('bid_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('supplier_organization_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('awarded_amount')->numeric(),
                Forms\Components\TextInput::make('award_percentage')->numeric(),
                Forms\Components\TextInput::make('currency')->maxLength(3)->default('USD'),
                Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'open' => 'Open', 'published' => 'Published', 'submitted' => 'Submitted', 'awarded' => 'Awarded', 'closed' => 'Closed', 'cancelled' => 'Cancelled', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'paid' => 'Paid', 'active' => 'Active', 'completed' => 'Completed'])->searchable(),
                Forms\Components\DateTimePicker::make('awarded_at'),
                Forms\Components\Textarea::make('notes')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('rfq_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('bid_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('supplier_organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('awarded_amount')->money(fn ($record) => $record->currency ?? 'USD')->sortable(),
                Tables\Columns\TextColumn::make('award_percentage')->money(fn ($record) => $record->currency ?? 'USD')->sortable(),
                Tables\Columns\TextColumn::make('currency')->searchable()->toggleable(),
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
            'index' => ListAwards::route('/'),
        ];
    }
}
