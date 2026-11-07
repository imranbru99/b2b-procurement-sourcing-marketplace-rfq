<?php

namespace App\Modules\Orders\PurchaseOrders\Services;

use App\Modules\Orders\GoodsReceipt\Models\Grn;
use App\Modules\Orders\Invoicing\Models\Invoice;
use App\Modules\Orders\Payments\Models\Payment;
use App\Modules\Orders\Payments\Services\PaymentService;
use App\Modules\Orders\PurchaseOrders\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderWorkflowService
{
    public function __construct(
        protected PaymentService $payments,
    ) {}

    /**
     * Advance a purchase order through GRN → invoice → payment.
     *
     * @param  array<string, mixed>  $options
     * @return array{po: PurchaseOrder, grn: Grn, invoice: Invoice, payment: Payment}
     */
    public function completeToPayment(PurchaseOrder $po, array $options = []): array
    {
        return DB::transaction(function () use ($po, $options) {
            $po->forceFill(['status' => 'issued', 'issued_at' => $po->issued_at ?? now()])->save();

            $grn = Grn::query()->create([
                'organization_id' => $po->organization_id,
                'purchase_order_id' => $po->id,
                'number' => $options['grn_number'] ?? 'GRN-'.Str::upper(Str::random(8)),
                'status' => 'received',
                'received_at' => now(),
            ]);

            $invoice = Invoice::query()->create([
                'organization_id' => $po->organization_id,
                'purchase_order_id' => $po->id,
                'grn_id' => $grn->id,
                'number' => $options['invoice_number'] ?? 'INV-'.Str::upper(Str::random(8)),
                'status' => 'approved',
                'currency' => $po->currency,
                'subtotal' => $po->subtotal,
                'tax_type' => $options['tax_type'] ?? 'VAT',
                'tax_rate' => $options['tax_rate'] ?? 0,
                'tax_total' => $po->tax_total,
                'total' => $po->total,
                'issued_at' => now(),
            ]);

            $payment = Payment::query()->create([
                'organization_id' => $po->organization_id,
                'invoice_id' => $invoice->id,
                'reference' => $options['payment_reference'] ?? 'PAY-'.Str::upper(Str::random(8)),
                'status' => 'pending',
                'method' => $options['gateway'] ?? 'stripe',
                'currency' => $po->currency,
                'amount' => $po->total,
            ]);

            $charged = $this->payments->charge($payment, (string) ($options['gateway'] ?? 'stripe'));

            return [
                'po' => $po->refresh(),
                'grn' => $grn,
                'invoice' => $invoice,
                'payment' => $charged['payment'],
            ];
        });
    }
}
