<?php

namespace App\Modules\Platform\DataImportExport\Filament\Platform\Resources;

use App\Modules\Platform\DataImportExport\Models\ExportJob;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class ExportJobResource extends BasePlatformResource
{
    protected static ?string $model = ExportJob::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Import / Export';

    public static function canAccess(): bool
    {
        return module_enabled('platform.data-import-export');
    }
    protected static ?string $slug = 'platform-export-job';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('type')->maxLength(32),
                Forms\Components\TextInput::make('file_path')->maxLength(255),
                Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'open' => 'Open', 'published' => 'Published', 'submitted' => 'Submitted', 'awarded' => 'Awarded', 'closed' => 'Closed', 'cancelled' => 'Cancelled', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'paid' => 'Paid', 'active' => 'Active', 'completed' => 'Completed'])->searchable(),
                Forms\Components\Textarea::make('stats')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('type')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('file_path')->searchable()->toggleable(),
                Tables\Columns\BadgeColumn::make('status'),
                Tables\Columns\TextColumn::make('stats')->searchable()->toggleable(),
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
            'index' => ExportJobResource\Pages\ListExportJobs::route('/'),
            'create' => ExportJobResource\Pages\CreateExportJob::route('/create'),
            'edit' => ExportJobResource\Pages\EditExportJob::route('/{record}/edit'),
        ];
    }
}
