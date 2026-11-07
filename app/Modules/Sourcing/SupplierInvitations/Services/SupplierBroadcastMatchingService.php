<?php

namespace App\Modules\Sourcing\SupplierInvitations\Services;

use App\Models\Organization;
use App\Modules\Sourcing\SupplierInvitations\Models\SupplierBroadcastProfile;
use Illuminate\Support\Collection;

class SupplierBroadcastMatchingService
{
    /**
     * @return Collection<int, Organization>
     */
    public function matchSuppliers(
        int $buyerOrganizationId,
        ?string $category = null,
        ?string $location = null,
        ?array $certifications = null,
        ?float $minRating = null,
    ): Collection {
        $profiles = SupplierBroadcastProfile::query()
            ->withoutGlobalScope('organization')
            ->where('organization_id', $buyerOrganizationId)
            ->where('is_active', true)
            ->when($category, fn ($q) => $q->where('category', $category))
            ->when($location, fn ($q) => $q->where('location', $location))
            ->when($minRating !== null, fn ($q) => $q->where('min_rating', '<=', $minRating))
            ->get();

        if ($profiles->isEmpty()) {
            return Organization::query()
                ->where('type', 'supplier')
                ->where('is_active', true)
                ->when($location, fn ($q) => $q->where('country', $location))
                ->get();
        }

        return Organization::query()
            ->where('type', 'supplier')
            ->where('is_active', true)
            ->when($location, fn ($q) => $q->where('country', $location))
            ->limit(50)
            ->get();
    }
}
