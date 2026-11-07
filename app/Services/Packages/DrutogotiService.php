<?php

namespace App\Services\Packages;

use Drutogoti\Models\Suggestion;
use Illuminate\Support\Arr;

/**
 * Application wrapper for the imrandevbd/drutogoti performance profiler.
 *
 * Configuration lives in config/drutogoti.php (publish via vendor:publish --tag=drutogoti-config).
 * Enable in non-production with DRUTOGOTI_ENABLED=true and prefer queue storage in production.
 *
 * @see https://github.com/imranbru99/laravel-speed-optimization-drutogoti
 */
class DrutogotiService
{
    public function isEnabled(): bool
    {
        return (bool) config('drutogoti.enabled', false);
    }

    /**
     * @return array<string, mixed>
     */
    public function config(): array
    {
        return (array) config('drutogoti', []);
    }

    /**
     * @return list<string>
     */
    public function enabledWatchers(): array
    {
        $watchers = Arr::get($this->config(), 'watchers', []);

        if (! is_array($watchers)) {
            return [];
        }

        return collect($watchers)
            ->filter(fn (mixed $settings): bool => is_array($settings) && ($settings['enabled'] ?? false))
            ->keys()
            ->values()
            ->all();
    }

    public function documentation(): string
    {
        return implode("\n", [
            'Drutogoti captures slow queries, N+1 patterns, cache events, cookie bloat, and unoptimized images.',
            'Set DRUTOGOTI_ENABLED=true to activate middleware capture.',
            'Use DRUTOGOTI_STORAGE_DRIVER=queue and a dedicated queue worker in production.',
            'Tune DRUTOGOTI_SAMPLE_RATE (0.0–1.0) to reduce telemetry volume.',
            'Dashboard routes are available when dashboard.enabled is true (default prefix: /drutogoti).',
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Suggestion>
     */
    public function openSuggestions(int $limit = 25)
    {
        if (! $this->isEnabled()) {
            return Suggestion::query()->whereRaw('1 = 0')->get();
        }

        return Suggestion::query()
            ->orderByDesc('last_seen_at')
            ->limit($limit)
            ->get();
    }
}
