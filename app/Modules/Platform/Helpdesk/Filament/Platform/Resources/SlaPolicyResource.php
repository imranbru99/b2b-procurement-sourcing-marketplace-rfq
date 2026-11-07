<?php

namespace App\Modules\Platform\Helpdesk\Filament\Platform\Resources;

use App\Modules\Platform\Helpdesk\Models\SlaPolicy;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class SlaPolicyResource extends BasePlatformResource
{
    protected static ?string $model = SlaPolicy::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Helpdesk';

    public static function canAccess(): bool
    {
        return module_enabled('platform.helpdesk');
    }
    protected static ?string $slug = 'platform-sla-policy';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('name')->maxLength(255),
                Forms\Components\TextInput::make('slug')->maxLength(255)->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('first_response_minutes')->maxLength(255),
                Forms\Components\TextInput::make('resolution_minutes')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('first_response_minutes')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('resolution_minutes')->searchable()->toggleable(),
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
            'index' => SlaPolicyResource\Pages\ListSlaPolicys::route('/'),
            'create' => SlaPolicyResource\Pages\CreateSlaPolicy::route('/create'),
            'edit' => SlaPolicyResource\Pages\EditSlaPolicy::route('/{record}/edit'),
        ];
    }
}
