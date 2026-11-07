<?php

namespace App\Modules\Suppliers\LeadsAdvertising\Filament\Buyer\Resources;

use App\Modules\Suppliers\LeadsAdvertising\Models\SponsoredListing;
use App\Modules\Suppliers\Support\Filament\BaseSupplierResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class SponsoredListingResource extends BaseSupplierResource
{
    protected static ?string $model = SponsoredListing::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'sponsored-listing-buyer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('supplier_profile_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('supplier_category_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('impressions')->maxLength(255),
                Forms\Components\TextInput::make('clicks')->maxLength(255),
                Forms\Components\DateTimePicker::make('starts_at'),
                Forms\Components\DateTimePicker::make('ends_at'),
                Forms\Components\Toggle::make('is_active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('supplier_profile_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('supplier_category_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('impressions')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('clicks')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('starts_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('ends_at')->dateTime()->sortable(),
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
            'index' => SponsoredListingResource\Pages\ListSponsoredListings::route('/'),
            'create' => SponsoredListingResource\Pages\CreateSponsoredListing::route('/create'),
            'edit' => SponsoredListingResource\Pages\EditSponsoredListing::route('/{record}/edit'),
        ];
    }
}
