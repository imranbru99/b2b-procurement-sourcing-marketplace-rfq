<?php

namespace App\Modules\Operations\InspectionAttendance\Filament\Resources;

use App\Modules\Operations\InspectionAttendance\Filament\Resources\SiteAuditResource\Pages;
use App\Modules\Operations\InspectionAttendance\Models\SiteAudit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteAuditResource extends Resource
{
    protected static ?string $model = SiteAudit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Operations';

    public static function canAccess(): bool
    {
        return module_enabled('operations.inspection-attendance');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('inspector_assignment_id')->numeric()->nullable(),
                Forms\Components\TextInput::make('title')->maxLength(255),
                Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'open' => 'Open', 'published' => 'Published', 'submitted' => 'Submitted', 'awarded' => 'Awarded', 'closed' => 'Closed', 'cancelled' => 'Cancelled', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'paid' => 'Paid', 'active' => 'Active', 'completed' => 'Completed'])->searchable(),
                Forms\Components\DateTimePicker::make('audited_at'),
                Forms\Components\TextInput::make('score')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('inspector_assignment_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('status'),
                Tables\Columns\TextColumn::make('audited_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('score')->searchable()->toggleable(),
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
            'index' => Pages\ListSiteAudits::route('/'),
            'create' => Pages\CreateSiteAudit::route('/create'),
            'edit' => Pages\EditSiteAudit::route('/{record}/edit'),
        ];
    }
}
