<?php

it('serves core public pages', function () {
    $paths = [
        '/' => 'home',
        '/features' => 'features',
        '/pricing' => 'pricing',
        '/try-demo' => 'demo.try',
    ];

    foreach ($paths as $path => $name) {
        $response = $this->get($path);
        $response->assertSuccessful();
    }
});

it('serves sitemap xml', function () {
    $this->get('/sitemap.xml')
        ->assertSuccessful()
        ->assertHeader('Content-Type', 'application/xml');
});

it('serves robots txt', function () {
    $this->get('/robots.txt')->assertSuccessful();
});
