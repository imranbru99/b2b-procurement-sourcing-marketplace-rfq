<?php

use App\Facades\Module;
use App\Models\User;

if (! function_exists('module_enabled')) {
    function module_enabled(string $key, ?int $organizationId = null): bool
    {
        return Module::enabled($key, $organizationId);
    }
}

if (! function_exists('organization_id')) {
    function organization_id(): ?int
    {
        $user = auth()->user();

        if ($user instanceof User && $user->current_organization_id) {
            return (int) $user->current_organization_id;
        }

        return session('current_organization_id') ? (int) session('current_organization_id') : null;
    }
}
