<?php

namespace App\Modules\Orders\Payments\Adapters;

use App\Modules\Orders\Payments\Adapters\Concerns\BuildsDemoGatewayResponse;
use App\Modules\Orders\Payments\Contracts\PaymentGatewayAdapterInterface;

/**
 * PayPal adapter. Live keys: PAYPAL_CLIENT_ID / PAYPAL_CLIENT_SECRET in .env
 * (config('services.paypal')).
 */
class PayPalAdapter implements PaymentGatewayAdapterInterface
{
    use BuildsDemoGatewayResponse;

    public function name(): string
    {
        return 'paypal';
    }

    public function charge(array $payload): array
    {
        return $this->demoChargeResponse(
            (array) config('services.paypal', []),
            $payload,
            'PAYID'
        );
    }

    public function refund(string $externalId, float $amount): array
    {
        return $this->demoRefundResponse($externalId, $amount);
    }
}
