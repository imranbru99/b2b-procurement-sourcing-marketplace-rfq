<x-filament-panels::page>
    <form wire:submit="send" class="space-y-6">
        {{ $this->form }}

        <x-filament::button type="submit">
            Send
        </x-filament::button>
    </form>

    @if ($reply)
        <div class="mt-6 rounded-xl border border-gray-200 bg-white p-4 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
            <p class="font-medium">Assistant</p>
            <p class="mt-2 whitespace-pre-wrap">{{ $reply }}</p>
        </div>
    @endif
</x-filament-panels::page>
