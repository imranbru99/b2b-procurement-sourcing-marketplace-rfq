<?php

use App\Models\Organization;
use App\Modules\ModuleRegistry;
use App\Modules\Platform\CmsBlog\Models\BlogPost;
use App\Modules\Platform\CmsBlog\Models\Page;

it('registers the cms blog platform module', function () {
    expect(app(ModuleRegistry::class)->keys())->toContain('platform.cms-blog');
});

it('stores multilingual cms content as json', function () {
    $organization = Organization::query()->create([
        'name' => 'Content Org',
        'type' => 'buyer',
    ]);

    $page = Page::query()->withoutGlobalScope('organization')->create([
        'organization_id' => $organization->id,
        'title' => 'About Us',
        'meta_title' => 'About',
        'meta_description' => 'About our marketplace',
        'content' => ['en' => 'English body', 'bn' => 'বাংলা'],
        'is_published' => true,
    ]);

    $post = BlogPost::query()->withoutGlobalScope('organization')->create([
        'organization_id' => $organization->id,
        'title' => 'Launch Post',
        'content' => ['en' => 'We launched'],
        'is_published' => true,
    ]);

    expect($page->fresh()->content['bn'])->toBe('বাংলা')
        ->and($post->slug)->not->toBeEmpty();
});
