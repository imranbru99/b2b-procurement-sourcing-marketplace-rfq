<?php

namespace App\Modules\Suppliers\KycOnboarding\Filament\Platform\Resources;

use App\Modules\Suppliers\KycOnboarding\Models\KycApplication;
use App\Modules\Suppliers\Support\Filament\BaseSupplierResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class KycApplicationResource extends BaseSupplierResource
{
    protected static ?string $model = KycApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'kyc-application-platform';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('supplier_profile_id')->numeric()->nullable(),
                Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'open' => 'Open', 'published' => 'Published', 'submitted' => 'Submitted', 'awarded' => 'Awarded', 'closed' => 'Closed', 'cancelled' => 'Cancelled', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'paid' => 'Paid', 'active' => 'Active', 'completed' => 'Completed'])->searchable(),
                Forms\Components\DateTimePicker::make('submitted_at'),
                Forms\Components\DateTimePicker::make('reviewed_at'),
                Forms\Components\TextInput::make('reviewed_by')->numeric(),
                Forms\Components\Textarea::make('review_notes')->columnSpanFull(),
                Forms\Components\Textarea::make('checklist')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('supplier_profile_id')->searchable()->toggleable(),
                Tables\Columns\BadgeColumn::make('status'),
                Tables\Columns\TextColumn::make('submitted_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('reviewed_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('reviewed_by')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('review_notes')->searchable()->toggleable(),
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
            'index' => KycApplicationResource\Pages\ListKycApplications::route('/'),
            'create' => KycApplicationResource\Pages\CreateKycApplication::route('/create'),
            'edit' => KycApplicationResource\Pages\EditKycApplication::route('/{record}/edit'),
        ];
    }
}
