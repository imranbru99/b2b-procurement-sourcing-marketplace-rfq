<?php

namespace App\Modules\Orders\Payments\Services;

use App\Modules\Orders\Payments\Models\GatewayTransaction;
use App\Modules\Orders\Payments\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService
{
    public function __construct(
        protected PaymentGatewayManager $gateways,
    ) {}

    /**
     * Charge a payment through the selected gateway adapter and persist a
     * GatewayTransaction with provider refs + idempotency key.
     *
     * @param  array<string, mixed>  $payload
     */
    public function charge(Payment $payment, ?string $gateway = null, array $payload = []): GatewayTransaction
    {
        $gateway ??= $payment->gateway ?: 'stripe';
        $idempotencyKey = (string) ($payload['idempotency_key'] ?? Str::uuid());

        $chargePayload = array_merge([
            'reference' => $payment->reference,
            'amount' => (float) $payment->amount,
            'currency' => $payment->currency,
            'payment_id' => $payment->id,
            'invoice_id' => $payment->invoice_id,
            'organization_id' => $payment->organization_id,
            'idempotency_key' => $idempotencyKey,
            'gateway' => $gateway,
        ], $payload);

        $result = $this->gateways->driver($gateway)->charge($chargePayload);

        return DB::transaction(function () use ($payment, $gateway, $result, $idempotencyKey, $chargePayload): GatewayTransaction {
            $transaction = GatewayTransaction::query()->create([
                'organization_id' => $payment->organization_id,
                'payment_id' => $payment->id,
                'gateway' => $gateway,
                'external_id' => $result['external_id'] ?? $result['provider_ref'] ?? null,
                'status' => $result['status'] ?? 'initiated',
                'payload' => array_merge($result, [
                    'request' => $chargePayload,
                    'idempotency_key' => $idempotencyKey,
                ]),
            ]);

            if (($result['status'] ?? null) === 'authorized') {
                $payment->forceFill([
                    'gateway' => $gateway,
                    'status' => 'paid',
                    'paid_at' => $payment->paid_at ?? now(),
                    'reference' => $payment->reference ?: ($result['reference'] ?? null),
                ])->save();
            }

            return $transaction;
        });
    }
}
