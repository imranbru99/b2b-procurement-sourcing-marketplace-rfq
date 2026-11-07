@extends('layouts.public')

@section('title', __('site.nav.directory'))

@section('content')
    <section class="page-hero full-bleed">
        <div class="site-container py-14">
            <h1 class="font-display text-4xl font-semibold">{{ __('site.nav.directory') }}</h1>
        </div>
    </section>
    <section class="site-section">
        <div class="site-container">
            <form method="get" class="mb-8 flex flex-wrap gap-2">
                <input type="search" name="q" value="{{ $search }}" placeholder="{{ app()->getLocale() === 'bn' ? 'খুঁজুন…' : 'Search…' }}" class="form-input max-w-md flex-1">
                <button class="btn btn-secondary" type="submit">{{ app()->getLocale() === 'bn' ? 'ফিল্টার' : 'Search' }}</button>
            </form>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($suppliers as $supplier)
                    <x-public.reveal>
                        <a href="{{ route('suppliers.show', $supplier->slug) }}" class="listing-tile block">
                            <h2 class="font-display font-semibold">{{ $supplier->company_name }}</h2>
                            @if ($supplier->tagline)
                                <p class="mt-1 text-sm text-[color:var(--muted)]">{{ $supplier->tagline }}</p>
                            @endif
                        </a>
                    </x-public.reveal>
                @empty
                    <p>{{ __('site.empty.suppliers') }}</p>
                @endforelse
            </div>
            <div class="mt-8">{{ $suppliers->links() }}</div>
        </div>
    </section>
@endsection
