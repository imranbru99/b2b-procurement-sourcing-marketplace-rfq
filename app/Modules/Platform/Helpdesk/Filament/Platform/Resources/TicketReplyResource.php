<?php

namespace App\Modules\Platform\Helpdesk\Filament\Platform\Resources;

use App\Modules\Platform\Helpdesk\Models\TicketReply;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class TicketReplyResource extends BasePlatformResource
{
    protected static ?string $model = TicketReply::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Helpdesk';

    public static function canAccess(): bool
    {
        return module_enabled('platform.helpdesk');
    }
    protected static ?string $slug = 'platform-ticket-reply';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ticket_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('user_id')->numeric()->nullable(),
                Forms\Components\Textarea::make('body')->columnSpanFull(),
                Forms\Components\Toggle::make('is_internal'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('ticket_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('user_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('body')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('is_internal')->searchable()->toggleable(),
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
            'index' => TicketReplyResource\Pages\ListTicketReplys::route('/'),
            'create' => TicketReplyResource\Pages\CreateTicketReply::route('/create'),
            'edit' => TicketReplyResource\Pages\EditTicketReply::route('/{record}/edit'),
        ];
    }
}
