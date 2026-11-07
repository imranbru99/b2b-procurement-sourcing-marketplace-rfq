<?php

namespace App\Modules\Platform\CmsBlog;

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
                \App\Modules\Platform\CmsBlog\Filament\Platform\Resources\PageResource::class,
                \App\Modules\Platform\CmsBlog\Filament\Platform\Resources\BlogPostResource::class,
                \App\Modules\Platform\CmsBlog\Filament\Platform\Resources\FaqResource::class,
                \App\Modules\Platform\CmsBlog\Filament\Platform\Resources\BannerResource::class
            ],
        ]);
        
    }

    protected function registerPolicies(): void
    {
        Gate::policy(\App\Modules\Platform\CmsBlog\Models\Page::class, \App\Modules\Platform\CmsBlog\Policies\PagePolicy::class);
        Gate::policy(\App\Modules\Platform\CmsBlog\Models\BlogPost::class, \App\Modules\Platform\CmsBlog\Policies\BlogPostPolicy::class);
        Gate::policy(\App\Modules\Platform\CmsBlog\Models\Faq::class, \App\Modules\Platform\CmsBlog\Policies\FaqPolicy::class);
        Gate::policy(\App\Modules\Platform\CmsBlog\Models\Banner::class, \App\Modules\Platform\CmsBlog\Policies\BannerPolicy::class);
    }
}
