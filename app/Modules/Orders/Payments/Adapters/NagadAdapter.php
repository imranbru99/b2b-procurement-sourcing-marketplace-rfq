<?php

namespace App\Modules\Orders\Payments\Adapters;

use App\Modules\Orders\Payments\Adapters\Concerns\BuildsDemoGatewayResponse;
use App\Modules\Orders\Payments\Contracts\PaymentGatewayAdapterInterface;

/**
 * Nagad adapter. Live key: NAGAD_MERCHANT_ID in .env (config('services.nagad')).
 */
class NagadAdapter implements PaymentGatewayAdapterInterface
{
    use BuildsDemoGatewayResponse;

    public function name(): string
    {
        return 'nagad';
    }

    public function charge(array $payload): array
    {
        return $this->demoChargeResponse(
            (array) config('services.nagad', []),
            $payload,
            'NGD'
        );
    }

    public function refund(string $externalId, float $amount): array
    {
        return $this->demoRefundResponse($externalId, $amount);
    }
}
