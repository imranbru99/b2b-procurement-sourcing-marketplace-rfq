@extends('layouts.public')

@section('title', __('site.nav.categories'))

@section('content')
    <section class="page-hero full-bleed">
        <div class="site-container py-14">
            <h1 class="font-display text-4xl font-semibold">{{ __('site.nav.categories') }}</h1>
        </div>
    </section>
    <section class="site-section">
        <div class="site-container flex flex-wrap gap-2">
            @forelse ($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="chip">{{ $category->name }}</a>
            @empty
                <p>{{ __('site.empty.categories') }}</p>
            @endforelse
        </div>
    </section>
@endsection
