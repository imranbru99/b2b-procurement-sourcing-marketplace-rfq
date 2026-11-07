<?php

namespace App\Modules\Platform\ApiIntegrations\Adapters;

use App\Modules\Platform\ApiIntegrations\Contracts\ErpConnectorAdapterInterface;

class OdooAdapter implements ErpConnectorAdapterInterface
{
    public function syncInvoices(): array
    {
        return [];
    }
}
