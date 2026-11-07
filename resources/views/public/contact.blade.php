@extends('layouts.public')

@section('title', __('site.contact.title'))

@section('content')
    <section class="page-hero full-bleed">
        <div class="site-container py-14">
            <h1 class="font-display text-4xl font-semibold">{{ __('site.contact.title') }}</h1>
        </div>
    </section>
    <section class="site-section">
        <div class="site-container max-w-xl">
            @if (session('success'))
                <p class="mb-6 rounded-lg border border-teal-700/30 bg-teal-900/10 px-4 py-3 text-sm text-teal-900 dark:text-teal-100">{{ session('success') }}</p>
            @endif
            <form method="post" action="{{ route('contact.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="form-label" for="name">{{ __('site.contact.name') }}</label>
                    <input class="form-input" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="email">{{ __('site.contact.email') }}</label>
                    <input class="form-input" type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="company">{{ __('site.contact.company') }}</label>
                    <input class="form-input" id="company" name="company" value="{{ old('company') }}">
                </div>
                <div>
                    <label class="form-label" for="phone">{{ __('site.contact.phone') }}</label>
                    <input class="form-input" id="phone" name="phone" value="{{ old('phone') }}">
                </div>
                <div>
                    <label class="form-label" for="subject">{{ __('site.contact.subject') }}</label>
                    <input class="form-input" id="subject" name="subject" value="{{ old('subject') }}">
                </div>
                <div>
                    <label class="form-label" for="message">{{ __('site.contact.message') }}</label>
                    <textarea class="form-input min-h-32" id="message" name="message" required>{{ old('message') }}</textarea>
                    @error('message') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="btn btn-primary">{{ __('site.contact.send') }}</button>
            </form>
        </div>
    </section>
@endsection
