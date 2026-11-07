<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Registered module keys
    |--------------------------------------------------------------------------
    |
    | Authoritative list of module keys shipped with the marketplace foundation.
    | Additional modules are auto-discovered from app/Modules (module.json files).
    |
    */

    'keys' => [
        'core.organizations',
        'core.users',
        'core.module-manager',
        'core.settings',
        'core.notifications',
        'core.audit-log',
        'core.file-manager',
        'core.localization',
        'core.dashboard',
        'marketplace.rfq',
        'marketplace.bids',
        'orders.purchase-orders',
        'orders.goods-receipt',
        'orders.invoicing',
        'orders.payments',
        'orders.escrow-wallet',
        'orders.disputes',
        'operations.logistics',
        'operations.inspection-attendance',
        'operations.budgets',
        'operations.inventory-lite',
        'operations.messaging',
        'sourcing.purchase-requisitions',
        'sourcing.rfqs',
        'sourcing.bidding',
        'sourcing.bid-scoring',
        'sourcing.reverse-auctions',
        'sourcing.negotiation',
        'sourcing.awards-contracts',
        'sourcing.supplier-invitations',
        'suppliers.directory',
        'suppliers.storefronts',
        'suppliers.catalog',
        'suppliers.kyc-onboarding',
        'suppliers.reviews-scorecards',
        'suppliers.risk-compliance',
        'suppliers.leads-advertising',
        'intelligence.ai-assistant',
        'intelligence.market-data',
        'intelligence.analytics',
        'platform.helpdesk',
        'platform.cms-blog',
        'platform.api-integrations',
        'platform.subscriptions-billing',
        'platform.security-center',
        'platform.data-import-export',
        'platform.multi-language-pdf',
    ],

    'cache_ttl' => (int) env('MODULE_CACHE_TTL', 3600),

];
