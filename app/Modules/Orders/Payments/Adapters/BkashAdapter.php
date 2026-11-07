<?php

namespace App\Modules\Orders\Payments\Adapters;

use App\Modules\Orders\Payments\Adapters\Concerns\BuildsDemoGatewayResponse;
use App\Modules\Orders\Payments\Contracts\PaymentGatewayAdapterInterface;

/**
 * bKash adapter. Live keys: BKASH_APP_KEY / BKASH_APP_SECRET in .env
 * (config('services.bkash')).
 */
class BkashAdapter implements PaymentGatewayAdapterInterface
{
    use BuildsDemoGatewayResponse;

    public function name(): string
    {
        return 'bkash';
    }

    public function charge(array $payload): array
    {
        return $this->demoChargeResponse(
            (array) config('services.bkash', []),
            $payload,
            'BKS'
        );
    }

    public function refund(string $externalId, float $amount): array
    {
        return $this->demoRefundResponse($externalId, $amount);
    }
}
