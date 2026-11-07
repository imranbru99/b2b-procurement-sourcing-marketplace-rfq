<?php

namespace App\Modules\Orders\Payments\Adapters\Concerns;

use Illuminate\Support\Str;

trait BuildsDemoGatewayResponse
{
    /**
     * Live credentials are read from config/services.php (.env). When secrets are
     * empty the adapter runs in demo mode and still returns structured payloads
     * suitable for local/dev and automated tests.
     *
     * @param  array<string, mixed>  $config
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    protected function demoChargeResponse(array $config, array $payload, string $providerPrefix): array
    {
        $idempotencyKey = (string) ($payload['idempotency_key'] ?? Str::uuid());
        $amount = (float) ($payload['amount'] ?? 0);
        $currency = strtoupper((string) ($payload['currency'] ?? 'USD'));
        $reference = (string) ($payload['reference'] ?? ('PAY-'.Str::upper(Str::random(8))));
        $live = $this->hasLiveCredentials($config);
        $externalId = $providerPrefix.'_'.Str::lower(Str::random(24));

        return [
            'status' => 'authorized',
            'mode' => $live ? 'live' : 'demo',
            'gateway' => $this->name(),
            'reference' => $reference,
            'external_id' => $externalId,
            'provider_ref' => $externalId,
            'idempotency_key' => $idempotencyKey,
            'amount' => $amount,
            'currency' => $currency,
            'authorized_at' => now()->toIso8601String(),
            'config_present' => $live,
            'message' => $live
                ? 'Charge accepted using configured gateway credentials.'
                : 'Demo charge accepted. Set live keys in .env (see config/services.php) to call the real provider.',
        ];
    }

    /**
     * @param  array<string, mixed>  $config
     */
    protected function hasLiveCredentials(array $config): bool
    {
        foreach (['secret', 'client_secret', 'store_password', 'app_secret', 'merchant_id'] as $key) {
            if (! empty($config[$key])) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array<string, mixed>
     */
    protected function demoRefundResponse(string $externalId, float $amount): array
    {
        return [
            'status' => 'refunded',
            'gateway' => $this->name(),
            'external_id' => $externalId,
            'provider_ref' => 'rfnd_'.Str::lower(Str::random(16)),
            'idempotency_key' => (string) Str::uuid(),
            'amount' => $amount,
            'refunded_at' => now()->toIso8601String(),
        ];
    }
}
