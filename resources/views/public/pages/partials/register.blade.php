<p class="text-[color:var(--muted)]">{{ app()->getLocale() === 'bn' ? 'নিবন্ধন Filament প্যানেলে সম্পন্ন হয়। প্রথমে ভূমিকা বেছে নিন।' : 'Registration is completed inside Filament. Start by choosing a role.' }}</p>
<div class="mt-8 grid gap-4 sm:grid-cols-2 not-prose">
    <a href="{{ url('/buyer/login') }}" class="listing-tile block text-center font-semibold">{{ app()->getLocale() === 'bn' ? 'ক্রেতা হিসেবে যোগ দিন' : 'Join as buyer' }}</a>
    <a href="{{ url('/supplier/login') }}" class="listing-tile block text-center font-semibold">{{ app()->getLocale() === 'bn' ? 'সরবরাহকারী হিসেবে যোগ দিন' : 'Join as supplier' }}</a>
</div>
<p class="mt-6 text-sm text-[color:var(--muted)]">
    <a href="{{ route('demo.request') }}" class="text-teal-800 dark:text-teal-300">{{ __('site.nav.demo_request') }}</a>
</p>
