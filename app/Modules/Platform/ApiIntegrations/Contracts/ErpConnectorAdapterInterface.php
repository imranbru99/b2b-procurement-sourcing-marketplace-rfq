<?php

namespace App\Modules\Platform\ApiIntegrations\Contracts;

interface ErpConnectorAdapterInterface
{
    /**
     * @return array<int, mixed>
     */
    public function syncInvoices(): array;
}
