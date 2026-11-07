<?php

namespace App\Modules\Intelligence\AiAssistant\Filament\Pages;

use App\Services\Packages\AiHubService;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class AiAssistantChatPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Intelligence';

    protected static ?string $navigationLabel = 'AI assistant';

    protected static ?int $navigationSort = 10;

    protected static string $view = 'intelligence.ai-assistant.chat';

    public ?string $message = null;

    public ?string $reply = null;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('message')
                    ->label('Message')
                    ->rows(4)
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function send(): void
    {
        $data = $this->form->getState();

        try {
            $this->reply = app(AiHubService::class)->chat((string) $data['message']);
            Notification::make()->title('Assistant replied')->success()->send();
        } catch (\Throwable $exception) {
            Notification::make()
                ->title('AI request failed')
                ->body($exception->getMessage())
                ->danger()
                ->send();
        }
    }
}
