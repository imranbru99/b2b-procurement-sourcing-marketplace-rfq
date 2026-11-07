<?php

namespace App\Modules\Platform\Helpdesk;

use App\Modules\Platform\Support\Concerns\RegistersFilamentResources;
use App\Modules\Platform\Support\Concerns\RegistersModuleMigrations;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use RegistersFilamentResources, RegistersModuleMigrations;

    public function register(): void {}

    public function boot(): void
    {
        $this->loadModuleMigrations();
        $this->registerPolicies();
        $this->registerFilamentForPanels([
            'platform' => [
                \App\Modules\Platform\Helpdesk\Filament\Platform\Resources\SlaPolicyResource::class,
                \App\Modules\Platform\Helpdesk\Filament\Platform\Resources\TicketResource::class,
                \App\Modules\Platform\Helpdesk\Filament\Platform\Resources\TicketReplyResource::class,
                \App\Modules\Platform\Helpdesk\Filament\Platform\Resources\KnowledgeBaseArticleResource::class
            ],
        ]);
        
    }

    protected function registerPolicies(): void
    {
        Gate::policy(\App\Modules\Platform\Helpdesk\Models\SlaPolicy::class, \App\Modules\Platform\Helpdesk\Policies\SlaPolicyPolicy::class);
        Gate::policy(\App\Modules\Platform\Helpdesk\Models\Ticket::class, \App\Modules\Platform\Helpdesk\Policies\TicketPolicy::class);
        Gate::policy(\App\Modules\Platform\Helpdesk\Models\TicketReply::class, \App\Modules\Platform\Helpdesk\Policies\TicketReplyPolicy::class);
        Gate::policy(\App\Modules\Platform\Helpdesk\Models\KnowledgeBaseArticle::class, \App\Modules\Platform\Helpdesk\Policies\KnowledgeBaseArticlePolicy::class);
    }
}
