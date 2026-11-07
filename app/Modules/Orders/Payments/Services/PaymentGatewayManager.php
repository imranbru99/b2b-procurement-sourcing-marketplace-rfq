<?php

namespace App\Modules\Orders\Payments\Services;

use App\Modules\Orders\Payments\Adapters\BkashAdapter;
use App\Modules\Orders\Payments\Adapters\NagadAdapter;
use App\Modules\Orders\Payments\Adapters\PayPalAdapter;
use App\Modules\Orders\Payments\Adapters\SslCommerzAdapter;
use App\Modules\Orders\Payments\Adapters\StripeAdapter;
use App\Modules\Orders\Payments\Contracts\PaymentGatewayAdapterInterface;
use InvalidArgumentException;

class PaymentGatewayManager implements PaymentGatewayAdapterInterface
{
    /**
     * @var array<string, PaymentGatewayAdapterInterface>
     */
    protected array $adapters;

    public function __construct()
    {
        $this->adapters = [
            'stripe' => new StripeAdapter,
            'paypal' => new PayPalAdapter,
            'sslcommerz' => new SslCommerzAdapter,
            'bkash' => new BkashAdapter,
            'nagad' => new NagadAdapter,
        ];
    }

    public function driver(?string $name = null): PaymentGatewayAdapterInterface
    {
        $name ??= 'stripe';
        $name = strtolower($name);

        if (! isset($this->adapters[$name])) {
            throw new InvalidArgumentException("Unknown payment gateway [{$name}].");
        }

        return $this->adapters[$name];
    }

    public function name(): string
    {
        return 'manager';
    }

    public function charge(array $payload): array
    {
        $gateway = $payload['gateway'] ?? 'stripe';

        return $this->driver((string) $gateway)->charge($payload);
    }

    public function refund(string $externalId, float $amount): array
    {
        return $this->driver('stripe')->refund($externalId, $amount);
    }
}
