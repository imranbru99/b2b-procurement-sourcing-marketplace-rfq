<?php

namespace App\Modules\Platform\Helpdesk\Filament\Platform\Resources;

use App\Modules\Platform\Helpdesk\Models\KnowledgeBaseArticle;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class KnowledgeBaseArticleResource extends BasePlatformResource
{
    protected static ?string $model = KnowledgeBaseArticle::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Helpdesk';

    public static function canAccess(): bool
    {
        return module_enabled('platform.helpdesk');
    }
    protected static ?string $slug = 'platform-knowledge-base-article';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('title')->maxLength(255),
                Forms\Components\TextInput::make('slug')->maxLength(255)->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('content')->columnSpanFull(),
                Forms\Components\TextInput::make('category')->maxLength(255),
                Forms\Components\DateTimePicker::make('published_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('organization_id')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('content')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('category')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('published_at')->dateTime()->sortable(),
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
            'index' => KnowledgeBaseArticleResource\Pages\ListKnowledgeBaseArticles::route('/'),
            'create' => KnowledgeBaseArticleResource\Pages\CreateKnowledgeBaseArticle::route('/create'),
            'edit' => KnowledgeBaseArticleResource\Pages\EditKnowledgeBaseArticle::route('/{record}/edit'),
        ];
    }
}
