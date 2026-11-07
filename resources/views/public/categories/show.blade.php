@extends('layouts.public')

@section('title', $category->name)

@section('content')
    <section class="page-hero full-bleed">
        <div class="site-container py-14">
            <h1 class="font-display text-4xl font-semibold">{{ $category->name }}</h1>
        </div>
    </section>
    <section class="site-section">
        <div class="site-container grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($suppliers as $supplier)
                <a href="{{ route('suppliers.show', $supplier->slug) }}" class="listing-tile block">{{ $supplier->company_name }}</a>
            @empty
                <p>{{ __('site.empty.suppliers') }}</p>
            @endforelse
        </div>
        <div class="mt-8">{{ $suppliers->links() }}</div>
    </section>
@endsection
