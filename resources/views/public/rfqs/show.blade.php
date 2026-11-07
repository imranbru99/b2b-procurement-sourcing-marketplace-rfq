@extends('layouts.public')

@section('title', $rfq->title)

@section('content')
    <section class="page-hero full-bleed">
        <div class="site-container py-14">
            <h1 class="font-display text-4xl font-semibold">{{ $rfq->title }}</h1>
            <p class="mt-2 text-sm text-[color:var(--muted)]">
                {{ strtoupper($rfq->type) }} · {{ $rfq->status }}
                @if ($rfq->deadline) · {{ app()->getLocale() === 'bn' ? 'শেষ সময়' : 'Deadline' }} {{ $rfq->deadline->format('M j, Y') }} @endif
            </p>
        </div>
    </section>
    <section class="site-section">
        <div class="site-container max-w-3xl prose-public">
            <x-public.reveal>
                <dl class="grid gap-4 sm:grid-cols-2 text-sm not-prose">
                    @if ($rfq->incoterms)
                        <div><dt class="text-[color:var(--muted)]">Incoterms</dt><dd>{{ $rfq->incoterms }}</dd></div>
                    @endif
                    @if ($rfq->payment_terms)
                        <div><dt class="text-[color:var(--muted)]">{{ app()->getLocale() === 'bn' ? 'পেমেন্ট' : 'Payment' }}</dt><dd>{{ $rfq->payment_terms }}</dd></div>
                    @endif
                    @if ($rfq->delivery_terms)
                        <div><dt class="text-[color:var(--muted)]">{{ app()->getLocale() === 'bn' ? 'ডেলিভারি' : 'Delivery' }}</dt><dd>{{ $rfq->delivery_terms }}</dd></div>
                    @endif
                </dl>
                <p class="mt-8 text-[color:var(--muted)]">
                    {{ app()->getLocale() === 'bn' ? 'সম্পূর্ণ লাইন আইটেম ও বিড জমা দিতে সরবরাহকারী প্যানেলে সাইন ইন করুন।' : 'Sign in to the supplier panel to view line items and submit bids.' }}
                </p>
                <a href="{{ url('/supplier') }}" class="btn btn-primary mt-6 inline-flex">{{ __('site.nav.login') }}</a>
            </x-public.reveal>
        </div>
    </section>
@endsection
