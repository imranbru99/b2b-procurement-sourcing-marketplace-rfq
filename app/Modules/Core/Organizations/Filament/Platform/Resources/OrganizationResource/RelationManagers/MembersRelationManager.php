<?php

namespace App\Modules\Core\Organizations\Filament\Platform\Resources\OrganizationResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $title = 'Members';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('User')
                ->options(fn (): array => User::query()->orderBy('name')->pluck('name', 'id')->all())
                ->searchable()
                ->required()
                ->disabledOn('edit'),
            Forms\Components\Select::make('role')
                ->options([
                    'owner' => 'Owner',
                    'admin' => 'Admin',
                    'member' => 'Member',
                    'viewer' => 'Viewer',
                ])
                ->required()
                ->default('member')
                ->native(false),
            Forms\Components\Toggle::make('is_primary')->default(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('pivot.role')->label('Role')->badge(),
                Tables\Columns\IconColumn::make('pivot.is_primary')->label('Primary')->boolean(),
                Tables\Columns\TextColumn::make('pivot.joined_at')->dateTime()->label('Joined'),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\Select::make('role')
                            ->options([
                                'owner' => 'Owner',
                                'admin' => 'Admin',
                                'member' => 'Member',
                                'viewer' => 'Viewer',
                            ])
                            ->required()
                            ->default('member'),
                        Forms\Components\Toggle::make('is_primary')->default(false),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        Forms\Components\Select::make('role')
                            ->options([
                                'owner' => 'Owner',
                                'admin' => 'Admin',
                                'member' => 'Member',
                                'viewer' => 'Viewer',
                            ])
                            ->required(),
                        Forms\Components\Toggle::make('is_primary'),
                    ]),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
