<?php

namespace App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources;

use App\Modules\Platform\ApiIntegrations\Models\ApiLog;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class ApiLogResource extends BasePlatformResource
{
    protected static ?string $model = ApiLog::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'API Integrations';

    public static function canAccess(): bool
    {
        return module_enabled('platform.api-integrations');
    }
    protected static ?string $slug = 'platform-api-log';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('method')->maxLength(255),
                Forms\Components\TextInput::make('path')->maxLength(255),
                Forms\Components\TextInput::make('status_code')->numeric(),
                Forms\Components\TextInput::make('duration_ms')->maxLength(255),
                Forms\Components\Textarea::make('request_body')->columnSpanFull(),
                Forms\Components\Textarea::make('response_body')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('method')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('path')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('status_code')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('duration_ms')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('request_body')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('response_body')->searchable()->toggleable(),
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
            'index' => ApiLogResource\Pages\ListApiLogs::route('/'),
            'create' => ApiLogResource\Pages\CreateApiLog::route('/create'),
            'edit' => ApiLogResource\Pages\EditApiLog::route('/{record}/edit'),
        ];
    }
}
