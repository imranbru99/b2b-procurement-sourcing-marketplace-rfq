@extends('layouts.public')

@section('title', __('site.pages.industries'))

@section('content')
    <section class="page-hero full-bleed">
        <div class="site-container py-14 md:py-20">
            <x-public.reveal>
                <h1 class="font-display text-4xl font-semibold">{{ __('site.pages.industries') }}</h1>
            </x-public.reveal>
        </div>
    </section>
    <section class="site-section">
        <div class="site-container prose-public max-w-3xl">
            <x-public.reveal>
                @include('public.pages.partials.industries')
            </x-public.reveal>
        </div>
    </section>
@endsection
