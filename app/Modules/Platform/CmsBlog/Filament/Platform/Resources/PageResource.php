<?php

namespace App\Modules\Platform\CmsBlog\Filament\Platform\Resources;

use App\Modules\Platform\CmsBlog\Models\Page;
use App\Modules\Platform\Support\Filament\BasePlatformResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends BasePlatformResource
{
    protected static ?string $model = Page::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'CMS & Blog';

    public static function canAccess(): bool
    {
        return module_enabled('platform.cms-blog');
    }
    protected static ?string $slug = 'platform-page';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('organization_id')->relationship('organization', 'name')->searchable()->required(),
                Forms\Components\TextInput::make('title')->maxLength(255),
                Forms\Components\TextInput::make('slug')->maxLength(255)->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('meta_title')->maxLength(255),
                Forms\Components\Textarea::make('meta_description')->columnSpanFull(),
                Forms\Components\TextInput::make('og_image')->maxLength(255),
                Forms\Components\Textarea::make('content')->columnSpanFull(),
                Forms\Components\Toggle::make('is_published'),
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
                Tables\Columns\TextColumn::make('meta_title')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('meta_description')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('og_image')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('content')->searchable()->toggleable(),
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
            'index' => PageResource\Pages\ListPages::route('/'),
            'create' => PageResource\Pages\CreatePage::route('/create'),
            'edit' => PageResource\Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
