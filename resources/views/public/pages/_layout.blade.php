@extends('layouts.public')

@section('title', $pageTitle ?? __('site.brand'))

@section('content')
    <section class="page-hero full-bleed">
        <div class="site-container py-14 md:py-20">
            <x-public.reveal>
                <h1 class="font-display text-4xl font-semibold tracking-tight">{{ $pageTitle }}</h1>
                @isset($pageLead)
                    <p class="mt-4 max-w-2xl text-lg text-[color:var(--muted)]">{{ $pageLead }}</p>
                @endisset
            </x-public.reveal>
        </div>
    </section>

    <section class="site-section">
        <div class="site-container prose-public max-w-3xl">
            {{ $slot ?? '' }}
            @yield('page_body')
        </div>
    </section>
@endsection
