<?php

namespace App\Modules\Platform\SubscriptionsBilling\Filament\Platform\Resources;

use App\Modules\Platform\SubscriptionsBilling\Models\SubscriptionInvoice;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class SubscriptionInvoiceResource extends BasePlatformResource
{
    protected static ?string $model = SubscriptionInvoice::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Subscriptions';

    public static function canAccess(): bool
    {
        return module_enabled('platform.subscriptions-billing');
    }
    protected static ?string $slug = 'platform-subscription-invoice';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('subscription_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('number')->maxLength(255),
                Forms\Components\TextInput::make('amount')->numeric(),
                Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'open' => 'Open', 'published' => 'Published', 'submitted' => 'Submitted', 'awarded' => 'Awarded', 'closed' => 'Closed', 'cancelled' => 'Cancelled', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'paid' => 'Paid', 'active' => 'Active', 'completed' => 'Completed'])->searchable(),
                Forms\Components\DateTimePicker::make('due_at'),
                Forms\Components\DateTimePicker::make('paid_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('subscription_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('number')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('amount')->money(fn ($record) => $record->currency ?? 'USD')->sortable(),
                Tables\Columns\BadgeColumn::make('status'),
                Tables\Columns\TextColumn::make('due_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('paid_at')->dateTime()->sortable(),
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
            'index' => SubscriptionInvoiceResource\Pages\ListSubscriptionInvoices::route('/'),
            'create' => SubscriptionInvoiceResource\Pages\CreateSubscriptionInvoice::route('/create'),
            'edit' => SubscriptionInvoiceResource\Pages\EditSubscriptionInvoice::route('/{record}/edit'),
        ];
    }
}
