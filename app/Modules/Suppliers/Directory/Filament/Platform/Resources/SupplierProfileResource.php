<?php

namespace App\Modules\Suppliers\Directory\Filament\Platform\Resources;

use App\Modules\Suppliers\Directory\Models\SupplierProfile;
use App\Modules\Suppliers\Support\Filament\BaseSupplierResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class SupplierProfileResource extends BaseSupplierResource
{
    protected static ?string $model = SupplierProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'supplier-profile-platform';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('company_name')->maxLength(255),
                Forms\Components\TextInput::make('slug')->maxLength(255)->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('tagline')->maxLength(255),
                Forms\Components\Textarea::make('description')->columnSpanFull(),
                Forms\Components\TextInput::make('country')->maxLength(255),
                Forms\Components\TextInput::make('region')->maxLength(255),
                Forms\Components\TextInput::make('city')->maxLength(255),
                Forms\Components\TextInput::make('lat')->numeric(),
                Forms\Components\TextInput::make('lng')->numeric(),
                Forms\Components\TextInput::make('website')->maxLength(255),
                Forms\Components\DateTimePicker::make('verified_at'),
                Forms\Components\TextInput::make('rating_avg')->numeric(),
                Forms\Components\TextInput::make('rating_count')->maxLength(255),
                Forms\Components\TextInput::make('moq')->maxLength(255),
                Forms\Components\TextInput::make('capacity')->maxLength(255),
                Forms\Components\TextInput::make('business_type')->maxLength(255),
                Forms\Components\TextInput::make('employee_count')->maxLength(255),
                Forms\Components\TextInput::make('year_founded')->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('company_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('tagline')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('description')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('country')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('region')->searchable()->toggleable(),
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
            'index' => SupplierProfileResource\Pages\ListSupplierProfiles::route('/'),
            'create' => SupplierProfileResource\Pages\CreateSupplierProfile::route('/create'),
            'edit' => SupplierProfileResource\Pages\EditSupplierProfile::route('/{record}/edit'),
        ];
    }
}
