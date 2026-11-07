<?php

namespace App\Modules\Suppliers\ReviewsScorecards\Filament\Buyer\Resources;

use App\Modules\Suppliers\ReviewsScorecards\Models\SupplierReview;
use App\Modules\Suppliers\Support\Filament\BaseSupplierResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class SupplierReviewResource extends BaseSupplierResource
{
    protected static ?string $model = SupplierReview::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'supplier-review-buyer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('supplier_profile_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('buyer_organization_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('author_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('purchase_order_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('rating')->maxLength(255),
                Forms\Components\TextInput::make('title')->maxLength(255),
                Forms\Components\Textarea::make('body')->columnSpanFull(),
                Forms\Components\Toggle::make('is_published'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('supplier_profile_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('buyer_organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('author_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('purchase_order_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('rating')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('body')->searchable()->toggleable(),
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
            'index' => SupplierReviewResource\Pages\ListSupplierReviews::route('/'),
            'create' => SupplierReviewResource\Pages\CreateSupplierReview::route('/create'),
            'edit' => SupplierReviewResource\Pages\EditSupplierReview::route('/{record}/edit'),
        ];
    }
}
