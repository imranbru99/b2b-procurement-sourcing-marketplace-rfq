<?php

namespace App\Modules\Platform\MultiLanguagePdf\Filament\Platform\Resources;

use App\Modules\Platform\MultiLanguagePdf\Models\DocumentTemplate;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class DocumentTemplateResource extends BasePlatformResource
{
    protected static ?string $model = DocumentTemplate::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'PDF Templates';

    public static function canAccess(): bool
    {
        return module_enabled('platform.multi-language-pdf');
    }
    protected static ?string $slug = 'platform-document-template';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('type')->maxLength(32),
                Forms\Components\Textarea::make('letterhead')->columnSpanFull(),
                Forms\Components\Textarea::make('body_html')->columnSpanFull(),
                Forms\Components\TextInput::make('locale')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('type')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('letterhead')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('body_html')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('locale')->searchable()->toggleable(),
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
            'index' => DocumentTemplateResource\Pages\ListDocumentTemplates::route('/'),
            'create' => DocumentTemplateResource\Pages\CreateDocumentTemplate::route('/create'),
            'edit' => DocumentTemplateResource\Pages\EditDocumentTemplate::route('/{record}/edit'),
        ];
    }
}
