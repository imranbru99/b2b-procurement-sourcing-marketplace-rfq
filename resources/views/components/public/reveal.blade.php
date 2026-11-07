@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'reveal '.$class]) }} x-reveal>
    {{ $slot }}
</div>
