@extends('layouts.public')

@section('title', __('site.brand'))

@section('meta_description', __('site.meta.default_description'))

@push('schema')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => __('site.brand'),
            'url' => url('/'),
            'description' => __('site.meta.default_description'),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@section('content')
    <section class="hero-atmosphere full-bleed">
        <div class="site-container hero-inner">
            <p class="hero-eyebrow font-display text-sm font-medium tracking-wide text-teal-700 dark:text-teal-300">
                {{ __('site.brand') }}
            </p>
            <h1 class="hero-headline font-display text-4xl font-semibold leading-tight sm:text-5xl lg:text-6xl">
                {{ __('site.hero.headline') }}
            </h1>
            <p class="hero-lede mt-5 max-w-2xl text-lg text-[color:var(--muted)]">
                {{ __('site.hero.sub') }}
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('suppliers.index') }}" class="btn btn-primary">{{ __('site.hero.cta_primary') }}</a>
                <a href="{{ route('rfqs.index') }}" class="btn btn-secondary">{{ __('site.hero.cta_secondary') }}</a>
                <a href="{{ route('register') }}" class="btn btn-ghost">{{ __('site.hero.cta_register') }}</a>
            </div>
        </div>
    </section>

    <section class="site-section">
        <div class="site-container">
            <x-public.reveal>
                <h2 class="section-title">{{ __('site.sections.how_it_works') }}</h2>
            </x-public.reveal>
            <div class="mt-10 grid gap-8 md:grid-cols-3">
                @foreach ([
                    ['step' => '01', 'title' => app()->getLocale() === 'bn' ? 'আবিষ্কার ও আমন্ত্রণ' : 'Discover & invite', 'body' => app()->getLocale() === 'bn' ? 'ডিরেক্টরি থেকে সরবরাহকারী খুঁজুন বা পাবলিক আরএফকিউ প্রকাশ করুন।' : 'Search the directory or publish a public RFQ with clear line items.'],
                    ['step' => '02', 'title' => app()->getLocale() === 'bn' ? 'বিড ও মূল্যায়ন' : 'Bid & evaluate', 'body' => app()->getLocale() === 'bn' ? 'সময়সীমার মধ্যে বিড সংগ্রহ করুন, স্কোরকার্ডে তুলনা করুন।' : 'Collect responses on deadline and compare with weighted scorecards.'],
                    ['step' => '03', 'title' => app()->getLocale() === 'bn' ? 'অর্ডার থেকে পরিশোধ' : 'Order to pay', 'body' => app()->getLocale() === 'bn' ? 'PO, GRN, ইনভয়েস ও পেমেন্ট মডিউল দিয়ে সম্পূর্ণ চক্র চালান।' : 'Run PO, GRN, invoicing, and payments with modular workflows.'],
                ] as $item)
                    <x-public.reveal class="step-panel">
                        <p class="text-xs font-semibold text-teal-700 dark:text-teal-300">{{ $item['step'] }}</p>
                        <h3 class="mt-2 font-display text-xl font-semibold">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-sm text-[color:var(--muted)]">{{ $item['body'] }}</p>
                    </x-public.reveal>
                @endforeach
            </div>
        </div>
    </section>

    <section class="site-section band-sand">
        <div class="site-container">
            <x-public.reveal>
                <h2 class="section-title">{{ __('site.sections.stats') }}</h2>
            </x-public.reveal>
            <dl class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($stats as $key => $value)
                    <x-public.reveal class="stat-tile">
                        <dt class="text-sm text-[color:var(--muted)]">{{ __('site.stats.'.$key) }}</dt>
                        <dd class="mt-1 font-display text-3xl font-semibold text-[color:var(--heading)]">{{ number_format($value) }}</dd>
                    </x-public.reveal>
                @endforeach
            </dl>
        </div>
    </section>

    <section class="site-section">
        <div class="site-container">
            <div class="flex items-end justify-between gap-4">
                <x-public.reveal>
                    <h2 class="section-title">{{ __('site.sections.featured_suppliers') }}</h2>
                </x-public.reveal>
                <a href="{{ route('suppliers.index') }}" class="text-sm font-medium text-teal-800 dark:text-teal-300">{{ __('site.nav.directory') }}</a>
            </div>
            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($featuredSuppliers as $supplier)
                    <x-public.reveal>
                        <a href="{{ route('suppliers.show', $supplier->slug) }}" class="listing-tile block">
                            <h3 class="font-display font-semibold">{{ $supplier->company_name }}</h3>
                            @if ($supplier->tagline)
                                <p class="mt-1 text-sm text-[color:var(--muted)]">{{ $supplier->tagline }}</p>
                            @endif
                            <p class="mt-3 text-xs text-[color:var(--muted)]">{{ collect([$supplier->city, $supplier->country])->filter()->join(', ') }}</p>
                        </a>
                    </x-public.reveal>
                @empty
                    <p class="text-sm text-[color:var(--muted)]">{{ __('site.empty.suppliers') }}</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="site-section band-muted">
        <div class="site-container">
            <div class="flex items-end justify-between gap-4">
                <x-public.reveal>
                    <h2 class="section-title">{{ __('site.sections.latest_rfqs') }}</h2>
                </x-public.reveal>
                <a href="{{ route('rfqs.index') }}" class="text-sm font-medium text-teal-800 dark:text-teal-300">{{ __('site.nav.rfqs') }}</a>
            </div>
            <ul class="mt-8 divide-y divide-[color:var(--border)]">
                @forelse ($latestRfqs as $rfq)
                    <x-public.reveal>
                        <li class="py-4">
                            <a href="{{ route('rfqs.show', $rfq->slug) }}" class="flex flex-wrap items-center justify-between gap-2">
                                <span class="font-medium">{{ $rfq->title }}</span>
                                @if ($rfq->deadline)
                                    <span class="text-xs text-[color:var(--muted)]">{{ $rfq->deadline->format('M j, Y') }}</span>
                                @endif
                            </a>
                        </li>
                    </x-public.reveal>
                @empty
                    <li class="py-4 text-sm text-[color:var(--muted)]">{{ __('site.empty.rfqs') }}</li>
                @endforelse
            </ul>
        </div>
    </section>

    <section class="site-section">
        <div class="site-container">
            <x-public.reveal>
                <h2 class="section-title">{{ __('site.sections.categories') }}</h2>
            </x-public.reveal>
            <div class="mt-8 flex flex-wrap gap-2">
                @forelse ($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="chip">{{ $category->name }}</a>
                @empty
                    <p class="text-sm text-[color:var(--muted)]">{{ __('site.empty.categories') }}</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="site-section">
        <div class="site-container grid gap-8 lg:grid-cols-3">
            @foreach ([
                app()->getLocale() === 'bn'
                    ? ['quote' => 'আমরা বিড তুলনার সময় অর্ধেক কমিয়েছি।', 'name' => 'রিমা চৌধুরী', 'role' => 'হেড অফ প্রকিউরমেন্ট']
                    : ['quote' => 'We cut bid comparison time in half.', 'name' => 'Rima Chowdhury', 'role' => 'Head of Procurement'],
                app()->getLocale() === 'bn'
                    ? ['quote' => 'পাবলিক আরএফকিউ আমাদের নতুন বায়ার এনেছে।', 'name' => 'করিম হোসেন', 'role' => 'সরবরাহকারী প্রতিনিধি']
                    : ['quote' => 'Public RFQs brought us qualified buyers.', 'name' => 'Karim Hossen', 'role' => 'Supplier representative'],
                app()->getLocale() === 'bn'
                    ? ['quote' => 'মডিউল অনুরূপে চালু করা স্কেলিং সহজ করেছে।', 'name' => 'সারা খান', 'role' => 'প্ল্যাটফর্ম অপারেটর']
                    : ['quote' => 'Turning modules on as we grew kept rollout calm.', 'name' => 'Sara Khan', 'role' => 'Platform operator'],
            ] as $t)
                <x-public.reveal class="quote-panel">
                    <p class="text-lg leading-relaxed">“{{ $t['quote'] }}”</p>
                    <footer class="mt-4 text-sm text-[color:var(--muted)]">
                        <strong class="text-[color:var(--heading)]">{{ $t['name'] }}</strong> — {{ $t['role'] }}
                    </footer>
                </x-public.reveal>
            @endforeach
        </div>
    </section>

    <section class="site-section cta-atmosphere full-bleed">
        <div class="site-container py-16 text-center">
            <x-public.reveal>
                <h2 class="font-display text-3xl font-semibold">{{ __('site.sections.cta') }}</h2>
                <p class="mx-auto mt-3 max-w-xl text-[color:var(--muted)]">{{ __('site.tagline') }}</p>
                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('demo.request') }}" class="btn btn-primary">{{ __('site.nav.demo_request') }}</a>
                    @if (config('app.demo') && Route::has('demo.try'))
                        <a href="{{ route('demo.try') }}" class="btn btn-secondary">{{ __('site.nav.demo') }}</a>
                    @endif
                </div>
            </x-public.reveal>
        </div>
    </section>
@endsection
