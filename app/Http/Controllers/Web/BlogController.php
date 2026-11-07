<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        $posts = collect(config('marketplace.blog_posts', []))
            ->sortByDesc('published_at')
            ->values();

        return view('public.blog.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = collect(config('marketplace.blog_posts', []))->firstWhere('slug', $slug);

        if (! $post) {
            abort(404);
        }

        $locale = app()->getLocale();

        return view('public.blog.show', [
            'post' => $post,
            'title' => $post['title'][$locale] ?? $post['title']['en'],
            'excerpt' => $post['excerpt'][$locale] ?? $post['excerpt']['en'],
            'body' => $post['body'][$locale] ?? $post['body']['en'],
        ]);
    }
}
