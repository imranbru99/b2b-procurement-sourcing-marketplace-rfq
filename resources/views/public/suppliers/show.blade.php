@extends('layouts.public')

@section('title', $supplier->company_name)

@section('meta_description', $supplier->tagline ?: Str::limit($supplier->description, 160))

@section('content')
    <section class="page-hero full-bleed">
        <div class="site-container py-14">
            <x-public.reveal>
                <h1 class="font-display text-4xl font-semibold">{{ $supplier->company_name }}</h1>
                @if ($supplier->tagline)
                    <p class="mt-3 text-lg text-[color:var(--muted)]">{{ $supplier->tagline }}</p>
                @endif
            </x-public.reveal>
        </div>
    </section>
    <section class="site-section">
        <div class="site-container prose-public max-w-3xl">
            <x-public.reveal>
                <dl class="grid gap-4 sm:grid-cols-2 text-sm not-prose">
                    @if ($supplier->city || $supplier->country)
                        <div><dt class="text-[color:var(--muted)]">{{ app()->getLocale() === 'bn' ? 'অবস্থান' : 'Location' }}</dt><dd>{{ collect([$supplier->city, $supplier->country])->filter()->join(', ') }}</dd></div>
                    @endif
                    @if ($supplier->website)
                        <div><dt class="text-[color:var(--muted)]">Web</dt><dd><a class="text-teal-800 dark:text-teal-300" href="{{ $supplier->website }}" rel="noopener">{{ $supplier->website }}</a></dd></div>
                    @endif
                    @if ($supplier->rating_count)
                        <div><dt class="text-[color:var(--muted)]">{{ app()->getLocale() === 'bn' ? 'রেটিং' : 'Rating' }}</dt><dd>{{ $supplier->rating_avg }} ({{ $supplier->rating_count }})</dd></div>
                    @endif
                </dl>
                @if ($supplier->description)
                    <div class="mt-8">{!! nl2br(e($supplier->description)) !!}</div>
                @endif
            </x-public.reveal>
        </div>
    </section>
@endsection
