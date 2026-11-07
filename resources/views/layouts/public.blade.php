@php
    $locale = app()->getLocale();
    $rtlLocales = config('marketplace.rtl_locales', []);
    $dir = in_array($locale, $rtlLocales, true) ? 'rtl' : 'ltr';
    $rawTitle = trim($__env->yieldContent('title'));
    $pageTitle = $rawTitle !== '' ? $rawTitle.' · '.__('site.brand') : __('site.brand');
    $metaDescription = trim($__env->yieldContent('meta_description')) ?: __('site.meta.default_description');
    $canonical = trim($__env->yieldContent('canonical')) ?: url()->current();
    $ogImage = trim($__env->yieldContent('og_image')) ?: asset('favicon.ico');
@endphp
<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', $locale) }}"
    dir="{{ $dir }}"
    x-data="publicSite()"
    x-init="init()"
    :class="{ 'dark': dark }"
    class="h-full scroll-smooth"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ $canonical }}">

    @foreach (config('marketplace.supported_locales', ['en']) as $altLocale)
        <link rel="alternate" hreflang="{{ $altLocale }}" href="{{ url()->current() }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ url('/') }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ __('site.brand') }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta name="twitter:card" content="summary_large_image">

    @stack('meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=Source+Sans+3:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    @stack('schema')
</head>
<body class="public-body min-h-full font-body antialiased">
    @if (config('app.demo'))
        <div class="demo-banner" role="status">
            <p>{{ __('site.demo.banner') }}
                @if (Route::has('demo.try'))
                    <a href="{{ route('demo.try') }}" class="underline decoration-sand-400 underline-offset-2">{{ __('site.nav.demo') }}</a>
                @endif
            </p>
        </div>
    @endif

    <header class="site-header">
        <div class="site-container flex items-center justify-between gap-6 py-4">
            <a href="{{ route('home') }}" class="brand-lockup group">
                <span class="brand-mark" aria-hidden="true"></span>
                <span class="brand-name">{{ __('site.brand') }}</span>
            </a>

            <nav class="hidden items-center gap-6 text-sm font-medium lg:flex" aria-label="{{ __('site.nav.product') }}">
                <a class="nav-link" href="{{ route('features') }}">{{ __('site.nav.features') }}</a>
                <a class="nav-link" href="{{ route('modules') }}">{{ __('site.nav.modules') }}</a>
                <a class="nav-link" href="{{ route('suppliers.index') }}">{{ __('site.nav.directory') }}</a>
                <a class="nav-link" href="{{ route('rfqs.index') }}">{{ __('site.nav.rfqs') }}</a>
                <a class="nav-link" href="{{ route('pricing') }}">{{ __('site.nav.pricing') }}</a>
            </nav>

            <div class="flex items-center gap-2 sm:gap-3">
                <div class="flex items-center rounded-full border border-[color:var(--border)] bg-[color:var(--surface)] p-0.5 text-xs">
                    @foreach (config('marketplace.supported_locales', ['en']) as $code)
                        <a
                            href="{{ route('locale.switch', $code) }}"
                            class="locale-pill {{ $locale === $code ? 'is-active' : '' }}"
                            hreflang="{{ $code }}"
                        >{{ strtoupper($code) }}</a>
                    @endforeach
                </div>

                <button
                    type="button"
                    class="icon-btn"
                    @click="toggleTheme()"
                    :aria-label="dark ? @js(__('site.theme.light')) : @js(__('site.theme.dark'))"
                >
                    <span x-show="!dark" class="sr-only">{{ __('site.theme.dark') }}</span>
                    <span x-show="dark" class="sr-only">{{ __('site.theme.light') }}</span>
                    <svg x-show="!dark" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-width="1.5" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                    <svg x-show="dark" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-width="1.5" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.36-6.36-1.42 1.42M7.05 16.95l-1.42 1.42m0-11.32 1.42 1.42m10.88 10.88 1.42 1.42M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/></svg>
                </button>

                <a href="{{ route('login') }}" class="hidden sm:inline nav-link">{{ __('site.nav.login') }}</a>
                <a href="{{ route('register') }}" class="btn btn-primary text-sm">{{ __('site.nav.register') }}</a>
            </div>
        </div>
    </header>

    <main id="main">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="site-container grid gap-10 py-16 md:grid-cols-4">
            <div class="md:col-span-2">
                <p class="font-display text-lg font-semibold text-[color:var(--heading)]">{{ __('site.brand') }}</p>
                <p class="mt-2 max-w-md text-sm text-[color:var(--muted)]">{{ __('site.tagline') }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-[color:var(--muted)]">{{ __('site.nav.product') }}</p>
                <ul class="mt-3 space-y-2 text-sm">
                    <li><a class="footer-link" href="{{ route('for-buyers') }}">{{ __('site.nav.buyers') }}</a></li>
                    <li><a class="footer-link" href="{{ route('for-suppliers') }}">{{ __('site.nav.suppliers') }}</a></li>
                    <li><a class="footer-link" href="{{ route('how-it-works') }}">{{ __('site.pages.how_it_works') }}</a></li>
                    <li><a class="footer-link" href="{{ route('industries') }}">{{ __('site.pages.industries') }}</a></li>
                </ul>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-[color:var(--muted)]">{{ __('site.nav.company') }}</p>
                <ul class="mt-3 space-y-2 text-sm">
                    <li><a class="footer-link" href="{{ route('about') }}">{{ __('site.nav.about') }}</a></li>
                    <li><a class="footer-link" href="{{ route('blog.index') }}">{{ __('site.nav.blog') }}</a></li>
                    <li><a class="footer-link" href="{{ route('contact') }}">{{ __('site.nav.contact') }}</a></li>
                    <li><a class="footer-link" href="{{ route('help') }}">{{ __('site.nav.help') }}</a></li>
                    <li><a class="footer-link" href="{{ route('demo.request') }}">{{ __('site.nav.demo_request') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-[color:var(--border)]">
            <div class="site-container flex flex-col gap-2 py-6 text-xs text-[color:var(--muted)] sm:flex-row sm:items-center sm:justify-between">
                <p>&copy; {{ date('Y') }} {{ __('site.brand') }}. {{ __('site.footer.rights') }}</p>
                <div class="flex gap-4">
                    <a class="footer-link" href="{{ route('terms') }}">{{ __('site.footer.terms') }}</a>
                    <a class="footer-link" href="{{ route('privacy') }}">{{ __('site.footer.privacy') }}</a>
                    <a class="footer-link" href="{{ route('faq') }}">{{ __('site.footer.faq') }}</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
    @stack('scripts')
</body>
</html>
