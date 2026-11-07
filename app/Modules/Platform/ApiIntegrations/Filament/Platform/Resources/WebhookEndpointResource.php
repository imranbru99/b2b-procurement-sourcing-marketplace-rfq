<?php

namespace App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources;

use App\Modules\Platform\ApiIntegrations\Models\WebhookEndpoint;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class WebhookEndpointResource extends BasePlatformResource
{
    protected static ?string $model = WebhookEndpoint::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'API Integrations';

    public static function canAccess(): bool
    {
        return module_enabled('platform.api-integrations');
    }
    protected static ?string $slug = 'platform-webhook-endpoint';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('name')->maxLength(255),
                Forms\Components\TextInput::make('url')->maxLength(255),
                Forms\Components\TextInput::make('secret')->maxLength(255),
                Forms\Components\Textarea::make('events')->columnSpanFull(),
                Forms\Components\Toggle::make('is_active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('url')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('secret')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('events')->searchable()->toggleable(),
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
            'index' => WebhookEndpointResource\Pages\ListWebhookEndpoints::route('/'),
            'create' => WebhookEndpointResource\Pages\CreateWebhookEndpoint::route('/create'),
            'edit' => WebhookEndpointResource\Pages\EditWebhookEndpoint::route('/{record}/edit'),
        ];
    }
}
