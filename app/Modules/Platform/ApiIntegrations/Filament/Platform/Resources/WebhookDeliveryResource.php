<?php

namespace App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources;

use App\Modules\Platform\ApiIntegrations\Models\WebhookDelivery;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class WebhookDeliveryResource extends BasePlatformResource
{
    protected static ?string $model = WebhookDelivery::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'API Integrations';

    public static function canAccess(): bool
    {
        return module_enabled('platform.api-integrations');
    }
    protected static ?string $slug = 'platform-webhook-delivery';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('webhook_endpoint_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('event')->maxLength(255),
                Forms\Components\Textarea::make('payload')->columnSpanFull(),
                Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'open' => 'Open', 'published' => 'Published', 'submitted' => 'Submitted', 'awarded' => 'Awarded', 'closed' => 'Closed', 'cancelled' => 'Cancelled', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'paid' => 'Paid', 'active' => 'Active', 'completed' => 'Completed'])->searchable(),
                Forms\Components\TextInput::make('response_code')->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('webhook_endpoint_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('event')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('payload')->searchable()->toggleable(),
                Tables\Columns\BadgeColumn::make('status'),
                Tables\Columns\TextColumn::make('response_code')->searchable()->toggleable(),
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
            'index' => WebhookDeliveryResource\Pages\ListWebhookDeliverys::route('/'),
            'create' => WebhookDeliveryResource\Pages\CreateWebhookDelivery::route('/create'),
            'edit' => WebhookDeliveryResource\Pages\EditWebhookDelivery::route('/{record}/edit'),
        ];
    }
}
