<?php

namespace App\Modules\Core\Users\Filament\Concerns;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

trait ConfiguresUserResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true)->maxLength(255),
            Forms\Components\TextInput::make('phone')->tel()->maxLength(50),
            Forms\Components\TextInput::make('locale')->maxLength(12)->default('en'),
            Forms\Components\TextInput::make('timezone')->maxLength(64)->default('UTC'),
            Forms\Components\TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) ? Hash::make($state) : null)
                ->dehydrated(fn (?string $state): bool => filled($state))
                ->required(fn (string $operation): bool => $operation === 'create')
                ->maxLength(255),
            Forms\Components\Toggle::make('is_platform_user')->default(false),
            Forms\Components\Select::make('roles')
                ->label('Roles')
                ->multiple()
                ->options(fn (): array => Role::query()->orderBy('name')->pluck('name', 'name')->all())
                ->preload()
                ->searchable(),
            Forms\Components\Select::make('organizations')
                ->label('Organizations')
                ->relationship('organizations', 'name')
                ->multiple()
                ->preload()
                ->searchable(),
            Forms\Components\Select::make('current_organization_id')
                ->label('Current organization')
                ->relationship('currentOrganization', 'name')
                ->searchable()
                ->preload()
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone')->toggleable(),
                Tables\Columns\TextColumn::make('locale')->toggleable(),
                Tables\Columns\TextColumn::make('timezone')->toggleable(),
                Tables\Columns\TextColumn::make('roles.name')->badge()->label('Roles'),
                Tables\Columns\TextColumn::make('organizations.name')->badge()->label('Organizations')->limitList(3),
                Tables\Columns\IconColumn::make('is_platform_user')->boolean()->label('Platform'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function mutateFormDataBeforeFill(array $data, ?Model $record = null): array
    {
        if ($record instanceof \App\Models\User) {
            $data['roles'] = $record->getRoleNames()->all();
        }

        return $data;
    }
}
