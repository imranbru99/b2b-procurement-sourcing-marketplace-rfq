@extends('layouts.public')

@section('title', $title)

@section('meta_description', $excerpt)

@section('content')
    <section class="page-hero full-bleed">
        <div class="site-container py-14">
            <p class="text-xs text-[color:var(--muted)]">{{ $post['published_at'] }} · {{ $post['author'] }}</p>
            <h1 class="mt-2 font-display text-4xl font-semibold">{{ $title }}</h1>
            <p class="mt-3 text-lg text-[color:var(--muted)]">{{ $excerpt }}</p>
        </div>
    </section>
    <section class="site-section">
        <div class="site-container prose-public max-w-3xl">
            {!! $body !!}
        </div>
    </section>
@endsection
