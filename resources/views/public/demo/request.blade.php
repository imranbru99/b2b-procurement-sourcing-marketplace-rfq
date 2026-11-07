@extends('layouts.public')

@section('title', __('site.pages.demo_request'))

@section('content')
    <section class="page-hero full-bleed">
        <div class="site-container py-14">
            <h1 class="font-display text-4xl font-semibold">{{ __('site.pages.demo_request') }}</h1>
        </div>
    </section>
    <section class="site-section">
        <div class="site-container max-w-xl">
            @if (session('success'))
                <p class="mb-6 rounded-lg border border-teal-700/30 bg-teal-900/10 px-4 py-3 text-sm">{{ session('success') }}</p>
            @endif
            <form method="post" action="{{ route('demo.request.store') }}" class="space-y-4">
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
                    <input class="form-input" id="company" name="company" value="{{ old('company') }}" required>
                    @error('company') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="role">Role</label>
                    <select class="form-input" id="role" name="role" required>
                        @foreach (['buyer', 'supplier', 'platform', 'logistics'] as $role)
                            <option value="{{ $role }}" @selected(old('role') === $role)>{{ ucfirst($role) }}</option>
                        @endforeach
                    </select>
                    @error('role') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="message">{{ __('site.contact.message') }}</label>
                    <textarea class="form-input min-h-24" id="message" name="message">{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('site.nav.demo_request') }}</button>
            </form>
        </div>
    </section>
@endsection
