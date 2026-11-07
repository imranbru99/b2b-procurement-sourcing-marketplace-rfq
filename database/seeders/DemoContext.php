<?php

namespace Database\Seeders;

use App\Models\Organization;

/**
 * Stable slugs and lookups for idempotent demo seeding.
 */
final class DemoContext
{
    public const PLATFORM_ORG = 'demo-platform-operations';

    public const BUYER_GARMENT = 'demo-buyer-garment-manufacturer';

    public const BUYER_HOSPITAL = 'demo-buyer-city-hospital';

    public const BUYER_GOVERNMENT = 'demo-buyer-government-procurement';

    public const LOGISTICS_ORG = 'demo-logistics-global';

    public const PRIMARY_SUPPLIER = 'demo-supplier-001';

    /**
     * @return list<string>
     */
    public static function buyerSlugs(): array
    {
        return [
            self::BUYER_GARMENT,
            self::BUYER_HOSPITAL,
            self::BUYER_GOVERNMENT,
        ];
    }

    public static function organization(string $slug): Organization
    {
        return Organization::query()->where('slug', $slug)->firstOrFail();
    }

    public static function supplierSlug(int $index): string
    {
        return sprintf('demo-supplier-%03d', $index);
    }
}
