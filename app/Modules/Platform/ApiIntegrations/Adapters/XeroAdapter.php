<?php

namespace App\Modules\Platform\ApiIntegrations\Adapters;

use App\Modules\Platform\ApiIntegrations\Contracts\ErpConnectorAdapterInterface;

class XeroAdapter implements ErpConnectorAdapterInterface
{
    public function syncInvoices(): array
    {
        return [];
    }
}
