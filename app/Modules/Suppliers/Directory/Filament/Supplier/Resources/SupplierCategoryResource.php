<?php

namespace App\Modules\Suppliers\Directory\Filament\Supplier\Resources;

use App\Modules\Suppliers\Directory\Models\SupplierCategory;
use App\Modules\Suppliers\Support\Filament\BaseSupplierResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class SupplierCategoryResource extends BaseSupplierResource
{
    protected static ?string $model = SupplierCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'supplier-category-supplier';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('parent_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('code')->maxLength(255),
                Forms\Components\TextInput::make('name')->maxLength(255),
                Forms\Components\TextInput::make('slug')->maxLength(255)->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('description')->columnSpanFull(),
                Forms\Components\TextInput::make('depth')->numeric(),
                Forms\Components\TextInput::make('sort_order')->numeric(),
                Forms\Components\Toggle::make('is_active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('parent_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('code')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('description')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('depth')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('sort_order')->searchable()->toggleable(),
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
            'index' => SupplierCategoryResource\Pages\ListSupplierCategorys::route('/'),
            'create' => SupplierCategoryResource\Pages\CreateSupplierCategory::route('/create'),
            'edit' => SupplierCategoryResource\Pages\EditSupplierCategory::route('/{record}/edit'),
        ];
    }
}
