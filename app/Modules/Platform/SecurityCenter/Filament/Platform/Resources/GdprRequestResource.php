<?php

namespace App\Modules\Platform\SecurityCenter\Filament\Platform\Resources;

use App\Modules\Platform\SecurityCenter\Models\GdprRequest;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class GdprRequestResource extends BasePlatformResource
{
    protected static ?string $model = GdprRequest::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Security Center';

    public static function canAccess(): bool
    {
        return module_enabled('platform.security-center');
    }
    protected static ?string $slug = 'platform-gdpr-request';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('user_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('type')->maxLength(32),
                Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'open' => 'Open', 'published' => 'Published', 'submitted' => 'Submitted', 'awarded' => 'Awarded', 'closed' => 'Closed', 'cancelled' => 'Cancelled', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'paid' => 'Paid', 'active' => 'Active', 'completed' => 'Completed'])->searchable(),
                Forms\Components\Textarea::make('payload')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('user_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('type')->searchable()->toggleable(),
                Tables\Columns\BadgeColumn::make('status'),
                Tables\Columns\TextColumn::make('payload')->searchable()->toggleable(),
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
            'index' => GdprRequestResource\Pages\ListGdprRequests::route('/'),
            'create' => GdprRequestResource\Pages\CreateGdprRequest::route('/create'),
            'edit' => GdprRequestResource\Pages\EditGdprRequest::route('/{record}/edit'),
        ];
    }
}
