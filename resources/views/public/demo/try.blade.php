@extends('layouts.public')

@section('title', __('site.demo.try_title'))

@section('content')
    <section class="page-hero full-bleed">
        <div class="site-container py-14">
            <h1 class="font-display text-4xl font-semibold">{{ __('site.demo.try_title') }}</h1>
            <p class="mt-3 max-w-2xl text-[color:var(--muted)]">{{ __('site.demo.try_sub') }}</p>
        </div>
    </section>
    <section class="site-section">
        <div class="site-container grid gap-4 md:grid-cols-2">
            @if (session('error'))
                <p class="md:col-span-2 rounded-lg border border-amber-700/40 bg-amber-900/10 px-4 py-3 text-sm">{{ session('error') }}</p>
            @endif
            @foreach ($logins as $login)
                <x-public.reveal class="listing-tile flex flex-col justify-between gap-4">
                    <div>
                        <h2 class="font-display text-lg font-semibold">{{ $login['label'] }}</h2>
                        <p class="mt-1 text-sm text-[color:var(--muted)]">{{ $login['email'] }}</p>
                    </div>
                    <form method="post" action="{{ route('demo.login', $login['panel']) }}">
                        @csrf
                        <button type="submit" class="btn btn-primary w-full">{{ __('site.demo.login_as', ['role' => $login['label']]) }}</button>
                    </form>
                </x-public.reveal>
            @endforeach
        </div>
    </section>
@endsection
