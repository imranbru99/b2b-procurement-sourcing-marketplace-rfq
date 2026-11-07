<?php

namespace App\Modules\Orders\Payments\Contracts;

interface PaymentGatewayAdapterInterface
{
    public function charge(array $payload): array;

    public function refund(string $externalId, float $amount): array;

    public function name(): string;
}
