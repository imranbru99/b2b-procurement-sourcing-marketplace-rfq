<?php

namespace App\Modules\Orders\Services;

use App\Models\Organization;
use App\Modules\Orders\GoodsReceipt\Models\Grn;
use App\Modules\Orders\Invoicing\Models\Invoice;
use App\Modules\Orders\Payments\Models\GatewayTransaction;
use App\Modules\Orders\Payments\Models\Payment;
use App\Modules\Orders\Payments\Services\PaymentService;
use App\Modules\Orders\PurchaseOrders\Models\PoItem;
use App\Modules\Orders\PurchaseOrders\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderWorkflowService
{
    public function __construct(
        protected PaymentService $payments,
    ) {}

    /**
     * Happy-path transition: Purchase Order → GRN → Invoice → Payment (+ gateway tx).
     *
     * @param  array<string, mixed>  $overrides
     * @return array{
     *     purchase_order: PurchaseOrder,
     *     grn: Grn,
     *     invoice: Invoice,
     *     payment: Payment,
     *     gateway_transaction: GatewayTransaction
     * }
     */
    public function completeOrderToPay(Organization $organization, array $overrides = []): array
    {
        return DB::transaction(function () use ($organization, $overrides): array {
            $suffix = Str::upper(Str::random(6));
            $subtotal = (float) ($overrides['subtotal'] ?? 1000);
            $taxTotal = (float) ($overrides['tax_total'] ?? 150);
            $total = (float) ($overrides['total'] ?? ($subtotal + $taxTotal));
            $currency = (string) ($overrides['currency'] ?? 'USD');
            $gateway = (string) ($overrides['gateway'] ?? 'stripe');

            $po = PurchaseOrder::withoutGlobalScopes()->create([
                'organization_id' => $organization->id,
                'supplier_organization_id' => $overrides['supplier_organization_id'] ?? null,
                'number' => $overrides['po_number'] ?? 'PO-'.$suffix,
                'status' => 'issued',
                'currency' => $currency,
                'subtotal' => $subtotal,
                'tax_total' => $taxTotal,
                'total' => $total,
                'issued_at' => now(),
                'expected_delivery_at' => now()->addDays(14),
                'notes' => $overrides['notes'] ?? 'Order workflow happy path',
            ]);

            PoItem::withoutGlobalScopes()->create([
                'organization_id' => $organization->id,
                'purchase_order_id' => $po->id,
                'sku' => $overrides['sku'] ?? 'SKU-1',
                'description' => $overrides['line_description'] ?? 'Line item',
                'quantity' => $overrides['quantity'] ?? 10,
                'unit_price' => $overrides['unit_price'] ?? ($subtotal / 10),
                'line_total' => $subtotal,
            ]);

            $grn = Grn::withoutGlobalScopes()->create([
                'organization_id' => $organization->id,
                'purchase_order_id' => $po->id,
                'number' => $overrides['grn_number'] ?? 'GRN-'.$suffix,
                'status' => 'received',
                'received_at' => now(),
                'warehouse' => $overrides['warehouse'] ?? 'Main',
            ]);

            $po->forceFill(['status' => 'received'])->save();

            $invoice = Invoice::withoutGlobalScopes()->create([
                'organization_id' => $organization->id,
                'purchase_order_id' => $po->id,
                'grn_id' => $grn->id,
                'number' => $overrides['invoice_number'] ?? 'INV-'.$suffix,
                'status' => 'approved',
                'currency' => $currency,
                'subtotal' => $subtotal,
                'tax_type' => $overrides['tax_type'] ?? 'GST',
                'tax_rate' => $overrides['tax_rate'] ?? 15,
                'tax_total' => $taxTotal,
                'total' => $total,
                'issued_at' => now(),
                'due_at' => now()->addDays(30),
            ]);

            $po->forceFill(['status' => 'invoiced'])->save();

            $payment = Payment::withoutGlobalScopes()->create([
                'organization_id' => $organization->id,
                'invoice_id' => $invoice->id,
                'reference' => $overrides['payment_reference'] ?? 'PAY-'.$suffix,
                'status' => 'pending',
                'method' => $overrides['method'] ?? 'card',
                'gateway' => $gateway,
                'currency' => $currency,
                'amount' => $total,
            ]);

            $transaction = $this->payments->charge($payment, $gateway, [
                'idempotency_key' => $overrides['idempotency_key'] ?? (string) Str::uuid(),
            ]);

            $invoice->forceFill(['status' => 'paid'])->save();
            $po->forceFill(['status' => 'completed'])->save();

            return [
                'purchase_order' => $po->fresh(),
                'grn' => $grn->fresh(),
                'invoice' => $invoice->fresh(),
                'payment' => $payment->fresh(),
                'gateway_transaction' => $transaction->fresh(),
            ];
        });
    }
}
