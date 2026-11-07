<p class="text-[color:var(--muted)]">{{ app()->getLocale() === 'bn' ? 'আপনার সংস্থার ভূমিকা অনুযায়ী প্যানেল বেছে নিন।' : 'Choose the panel that matches your organization role.' }}</p>
<ul class="mt-8 space-y-3 not-prose">
    @foreach ([
        ['label' => 'Buyer', 'path' => '/buyer'],
        ['label' => 'Supplier', 'path' => '/supplier'],
        ['label' => 'Platform', 'path' => '/platform'],
        ['label' => 'Logistics', 'path' => '/logistics'],
        ['label' => 'Admin', 'path' => '/admin'],
    ] as $panel)
        <li>
            <a class="btn btn-secondary w-full justify-center sm:w-auto" href="{{ url($panel['path']) }}">{{ $panel['label'] }} {{ app()->getLocale() === 'bn' ? 'প্যানেল' : 'panel' }}</a>
        </li>
    @endforeach
</ul>
