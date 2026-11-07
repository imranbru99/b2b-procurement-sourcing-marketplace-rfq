<?php

namespace App\Modules\Orders\Payments\Adapters;

use App\Modules\Orders\Payments\Adapters\Concerns\BuildsDemoGatewayResponse;
use App\Modules\Orders\Payments\Contracts\PaymentGatewayAdapterInterface;

/**
 * SSLCommerz adapter. Live keys: SSLCOMMERZ_STORE_ID / SSLCOMMERZ_STORE_PASSWORD
 * in .env (config('services.sslcommerz')).
 */
class SslCommerzAdapter implements PaymentGatewayAdapterInterface
{
    use BuildsDemoGatewayResponse;

    public function name(): string
    {
        return 'sslcommerz';
    }

    public function charge(array $payload): array
    {
        return $this->demoChargeResponse(
            (array) config('services.sslcommerz', []),
            $payload,
            'SSLCZ'
        );
    }

    public function refund(string $externalId, float $amount): array
    {
        return $this->demoRefundResponse($externalId, $amount);
    }
}
