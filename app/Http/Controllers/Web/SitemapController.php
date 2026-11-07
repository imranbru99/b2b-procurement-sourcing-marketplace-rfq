<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use App\Modules\Suppliers\Directory\Models\SupplierCategory;
use App\Modules\Suppliers\Directory\Models\SupplierProfile;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = [];

        foreach (config('marketplace.sitemap_static', []) as $routeName) {
            if (Route::has($routeName)) {
                $urls[] = [
                    'loc' => route($routeName),
                    'changefreq' => 'weekly',
                    'priority' => $routeName === 'home' ? '1.0' : '0.7',
                ];
            }
        }

        if (config('app.demo') && Route::has('demo.try')) {
            $urls[] = [
                'loc' => route('demo.try'),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ];
        }

        foreach (config('marketplace.blog_posts', []) as $post) {
            if (Route::has('blog.show')) {
                $urls[] = [
                    'loc' => route('blog.show', $post['slug']),
                    'changefreq' => 'monthly',
                    'priority' => '0.5',
                ];
            }
        }

        if (class_exists(SupplierProfile::class)) {
            SupplierProfile::query()->select(['slug', 'updated_at'])->orderBy('id')->chunk(200, function ($profiles) use (&$urls) {
                foreach ($profiles as $profile) {
                    $urls[] = [
                        'loc' => route('suppliers.show', $profile->slug),
                        'lastmod' => optional($profile->updated_at)?->toAtomString(),
                        'changefreq' => 'weekly',
                        'priority' => '0.6',
                    ];
                }
            });
        }

        if (class_exists(SupplierCategory::class)) {
            SupplierCategory::query()->select(['slug', 'updated_at'])->orderBy('id')->chunk(200, function ($categories) use (&$urls) {
                foreach ($categories as $category) {
                    $urls[] = [
                        'loc' => route('categories.show', $category->slug),
                        'lastmod' => optional($category->updated_at)?->toAtomString(),
                        'changefreq' => 'monthly',
                        'priority' => '0.5',
                    ];
                }
            });
        }

        if (class_exists(Rfq::class)) {
            Rfq::query()
                ->where('visibility', 'public')
                ->whereIn('status', ['open', 'published'])
                ->select(['slug', 'updated_at'])
                ->orderByDesc('id')
                ->chunk(200, function ($rfqs) use (&$urls) {
                    foreach ($rfqs as $rfq) {
                        $urls[] = [
                            'loc' => route('rfqs.show', $rfq->slug),
                            'lastmod' => optional($rfq->updated_at)?->toAtomString(),
                            'changefreq' => 'daily',
                            'priority' => '0.6',
                        ];
                    }
                });
        }

        return response()
            ->view('public.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }
}
