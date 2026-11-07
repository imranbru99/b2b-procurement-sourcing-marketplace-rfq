@extends('layouts.public')

@section('title', __('site.pages.blog'))

@section('content')
    <section class="page-hero full-bleed">
        <div class="site-container py-14">
            <h1 class="font-display text-4xl font-semibold">{{ __('site.pages.blog') }}</h1>
        </div>
    </section>
    <section class="site-section">
        <div class="site-container space-y-8">
            @foreach ($posts as $post)
                @php $locale = app()->getLocale(); @endphp
                <x-public.reveal>
                    <article class="border-b border-[color:var(--border)] pb-8">
                        <p class="text-xs text-[color:var(--muted)]">{{ $post['published_at'] }} · {{ $post['author'] }}</p>
                        <h2 class="mt-2 font-display text-2xl font-semibold">
                            <a href="{{ route('blog.show', $post['slug']) }}">{{ $post['title'][$locale] ?? $post['title']['en'] }}</a>
                        </h2>
                        <p class="mt-2 text-[color:var(--muted)]">{{ $post['excerpt'][$locale] ?? $post['excerpt']['en'] }}</p>
                    </article>
                </x-public.reveal>
            @endforeach
        </div>
    </section>
@endsection
