@extends('layouts.public')

@section('title', __('site.pages.features'))

@section('content')
    <section class="page-hero full-bleed">
        <div class="site-container py-14 md:py-20">
            <x-public.reveal>
                <h1 class="font-display text-4xl font-semibold">{{ __('site.pages.features') }}</h1>
                <p class="mt-4 max-w-2xl text-lg text-[color:var(--muted)]">{{ __('site.tagline') }}</p>
            </x-public.reveal>
        </div>
    </section>

    @php
        $groups = [
            'Sourcing' => [
                app()->getLocale() === 'bn' ? 'ক্রয় অনুরোধ, আরএফকিউ, বিড ও চুক্তি পুরস্কার' : 'Requisitions, RFQs, bids, and contract awards',
                app()->getLocale() === 'bn' ? 'পাবলিক বোর্ড ও সময়সীমা নিয়ন্ত্রণ' : 'Public board with deadline governance',
            ],
            'Suppliers' => [
                app()->getLocale() === 'bn' ? 'ডিরেক্টরি, স্টোরফ্রন্ট, ক্যাটালগ, KYC' : 'Directory, storefronts, catalog, and KYC',
                app()->getLocale() === 'bn' ? 'রিভিউ স্কোরকার্ড ও ঝুঁকি সম্মতি' : 'Review scorecards and risk compliance',
            ],
            'Orders' => [
                app()->getLocale() === 'bn' ? 'PO, GRN, ইনভয়েস, পেমেন্ট, এসক্রো' : 'PO, GRN, invoicing, payments, escrow',
                app()->getLocale() === 'bn' ? 'বিবাদ ও প্রমাণের চেইন' : 'Disputes with evidence trails',
            ],
            'Operations' => [
                app()->getLocale() === 'bn' ? 'লজিস্টিকস, ইনভেন্টরি, বাজেট, মেসেজিং' : 'Logistics, inventory, budgets, messaging',
                app()->getLocale() === 'bn' ? 'সাইট অডিট ও উপস্থিতি' : 'Site audits and attendance',
            ],
        ];
    @endphp

    @foreach ($groups as $name => $points)
        <section class="site-section {{ $loop->odd ? 'band-muted' : '' }}">
            <div class="site-container">
                <x-public.reveal>
                    <h2 class="font-display text-2xl font-semibold">{{ $name }}</h2>
                    <ul class="mt-4 space-y-2 text-[color:var(--muted)]">
                        @foreach ($points as $point)
                            <li class="flex gap-2"><span class="text-teal-700 dark:text-teal-300">—</span> {{ $point }}</li>
                        @endforeach
                    </ul>
                </x-public.reveal>
            </div>
        </section>
    @endforeach
@endsection
