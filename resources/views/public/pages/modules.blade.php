@extends('layouts.public')

@section('title', __('site.pages.modules'))

@section('content')
    <section class="page-hero full-bleed">
        <div class="site-container py-14 md:py-20">
            <x-public.reveal>
                <h1 class="font-display text-4xl font-semibold">{{ __('site.pages.modules') }}</h1>
                <p class="mt-4 max-w-2xl text-lg text-[color:var(--muted)]">
                    {{ app()->getLocale() === 'bn' ? 'মডিউল চালু করুন বা বন্ধ করুন — নেভিগেশন ও রুট তখনই আপডেট হয়।' : 'Toggle modules on or off — navigation and routes update through the registry.' }}
                </p>
            </x-public.reveal>
        </div>
    </section>

    <section class="site-section" x-data="{ active: @js($modules[0] ?? 'sourcing.rfqs') }">
        <div class="site-container grid gap-8 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-[color:var(--muted)]">
                    {{ app()->getLocale() === 'bn' ? 'মডিউল নির্বাচন' : 'Pick a module' }}
                </p>
                <ul class="mt-4 space-y-1">
                    @foreach ($modules as $module)
                        <li>
                            <button
                                type="button"
                                class="module-toggle w-full text-left"
                                :class="{ 'is-active': active === @js($module) }"
                                @click="active = @js($module)"
                            >{{ $module }}</button>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="lg:col-span-8">
                <x-public.reveal class="module-explainer">
                    @foreach ($modules as $module)
                        <div x-show="active === @js($module)" x-cloak>
                            <h2 class="font-display text-2xl font-semibold">{{ $module }}</h2>
                            <p class="mt-3 text-[color:var(--muted)]">
                                {{ app()->getLocale() === 'bn'
                                    ? 'এই মডিউলটি আপনার সংস্থার জন্য সক্রিয় থাকলে Filament প্যানেলে সম্পদ ও ওয়ার্কফ্লো দেখা যাবে।'
                                    : 'When enabled for your organization, this module surfaces resources and workflows in the Filament panels.' }}
                            </p>
                            <ul class="mt-6 list-disc space-y-2 pl-5 text-sm">
                                <li>{{ app()->getLocale() === 'bn' ? 'ক্রেতা, সরবরাহকারী ও অপারেটর ভূমিকা অনুযায়ী পৃথক UI' : 'Separate buyer, supplier, and operator experiences' }}</li>
                                <li>{{ app()->getLocale() === 'bn' ? 'সংস্থা-নির্দিষ্ট টগল `module_enabled()` দিয়ে' : 'Org-scoped toggles via `module_enabled()`' }}</li>
                                <li>{{ app()->getLocale() === 'bn' ? 'ডেটা মডেল ও মাইগ্রেশন মডিউলের মালিকানায়' : 'Owned migrations and domain models per module' }}</li>
                            </ul>
                        </div>
                    @endforeach
                    @if (count($modules) === 0)
                        <p class="text-[color:var(--muted)]">{{ app()->getLocale() === 'bn' ? 'কোনো মডিউল নিবন্ধিত নয়।' : 'No modules registered yet.' }}</p>
                    @endif
                </x-public.reveal>
            </div>
        </div>
    </section>
@endsection
