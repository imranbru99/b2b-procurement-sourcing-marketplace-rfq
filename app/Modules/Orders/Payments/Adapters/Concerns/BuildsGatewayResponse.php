<?php

namespace App\Modules\Orders\Payments\Adapters\Concerns;

use Illuminate\Support\Str;

trait BuildsGatewayResponse
{
    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    protected function authorizedResponse(array $payload, string $gateway, ?string $configKey = null): array
    {
        $live = filled(config($configKey));

        return [
            'status' => 'authorized',
            'mode' => $live ? 'live' : 'demo',
            'gateway' => $gateway,
            'reference' => $payload['reference'] ?? null,
            'external_id' => $payload['external_id'] ?? strtoupper($gateway).'_'.Str::upper(Str::random(12)),
            'idempotency_key' => $payload['idempotency_key'] ?? (string) Str::uuid(),
            'amount' => (float) ($payload['amount'] ?? 0),
            'currency' => strtoupper((string) ($payload['currency'] ?? 'USD')),
            'authorized_at' => now()->toIso8601String(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function refundedResponse(string $gateway, string $externalId, float $amount): array
    {
        return [
            'status' => 'refunded',
            'gateway' => $gateway,
            'external_id' => $externalId,
            'refund_id' => 'RFND_'.Str::upper(Str::random(10)),
            'amount' => $amount,
            'refunded_at' => now()->toIso8601String(),
        ];
    }
}
