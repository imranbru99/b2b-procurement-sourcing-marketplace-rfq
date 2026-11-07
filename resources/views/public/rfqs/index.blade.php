@extends('layouts.public')

@section('title', __('site.nav.rfqs'))

@section('content')
    <section class="page-hero full-bleed">
        <div class="site-container py-14">
            <h1 class="font-display text-4xl font-semibold">{{ __('site.nav.rfqs') }}</h1>
        </div>
    </section>
    <section class="site-section">
        <div class="site-container">
            <ul class="divide-y divide-[color:var(--border)]">
                @forelse ($rfqs as $rfq)
                    <x-public.reveal>
                        <li class="py-5">
                            <a href="{{ route('rfqs.show', $rfq->slug) }}" class="block">
                                <h2 class="font-display text-lg font-semibold">{{ $rfq->title }}</h2>
                                <p class="mt-1 text-sm text-[color:var(--muted)]">
                                    {{ $rfq->status }}
                                    @if ($rfq->deadline) · {{ $rfq->deadline->format('M j, Y') }} @endif
                                </p>
                            </a>
                        </li>
                    </x-public.reveal>
                @empty
                    <li class="py-5">{{ __('site.empty.rfqs') }}</li>
                @endforelse
            </ul>
            <div class="mt-8">{{ $rfqs->links() }}</div>
        </div>
    </section>
@endsection
