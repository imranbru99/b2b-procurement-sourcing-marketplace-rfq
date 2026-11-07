<?php

namespace App\Modules\Orders\Payments\Adapters;

use App\Modules\Orders\Payments\Adapters\Concerns\BuildsDemoGatewayResponse;
use App\Modules\Orders\Payments\Contracts\PaymentGatewayAdapterInterface;

/**
 * Stripe payment adapter. Live keys: STRIPE_KEY / STRIPE_SECRET in .env
 * (config('services.stripe')). Without secrets the adapter returns demo payloads.
 */
class StripeAdapter implements PaymentGatewayAdapterInterface
{
    use BuildsDemoGatewayResponse;

    public function name(): string
    {
        return 'stripe';
    }

    public function charge(array $payload): array
    {
        return $this->demoChargeResponse(
            (array) config('services.stripe', []),
            $payload,
            'pi'
        );
    }

    public function refund(string $externalId, float $amount): array
    {
        return $this->demoRefundResponse($externalId, $amount);
    }
}
