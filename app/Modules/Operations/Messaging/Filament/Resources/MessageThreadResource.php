<?php

namespace App\Modules\Operations\Messaging\Filament\Resources;

use App\Modules\Operations\Messaging\Filament\Resources\MessageThreadResource\Pages;
use App\Modules\Operations\Messaging\Models\MessageThread;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MessageThreadResource extends Resource
{
    protected static ?string $model = MessageThread::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Operations';

    public static function canAccess(): bool
    {
        return module_enabled('operations.messaging');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('subject_type')->maxLength(255),
                Forms\Components\TextInput::make('subject_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('title')->maxLength(255),
                Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'open' => 'Open', 'published' => 'Published', 'submitted' => 'Submitted', 'awarded' => 'Awarded', 'closed' => 'Closed', 'cancelled' => 'Cancelled', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'paid' => 'Paid', 'active' => 'Active', 'completed' => 'Completed'])->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('subject_type')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('subject_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('status'),
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
            'index' => Pages\ListMessageThreads::route('/'),
            'create' => Pages\CreateMessageThread::route('/create'),
            'edit' => Pages\EditMessageThread::route('/{record}/edit'),
        ];
    }
}
