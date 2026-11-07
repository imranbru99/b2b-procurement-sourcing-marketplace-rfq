<?php

use App\Models\Organization;
use App\Modules\Orders\GoodsReceipt\Models\Grn;
use App\Modules\Orders\Invoicing\Models\Invoice;
use App\Modules\Orders\Payments\Models\Payment;
use App\Modules\Orders\PurchaseOrders\Models\PoItem;
use App\Modules\Orders\PurchaseOrders\Models\PurchaseOrder;
use Database\Seeders\ModuleSeeder;

beforeEach(function () {
    $this->seed(ModuleSeeder::class);
});

it('completes order-to-pay flow from PO through payment', function () {
    $organization = Organization::factory()->create(['type' => 'buyer']);

    $po = PurchaseOrder::withoutGlobalScopes()->create([
        'organization_id' => $organization->id,
        'number' => 'PO-FLOW-001',
        'status' => 'issued',
        'currency' => 'USD',
        'subtotal' => 1000,
        'tax_total' => 150,
        'total' => 1150,
        'issued_at' => now(),
    ]);

    $line = PoItem::withoutGlobalScopes()->create([
        'organization_id' => $organization->id,
        'purchase_order_id' => $po->id,
        'description' => 'Industrial valves',
        'quantity' => 10,
        'unit_price' => 100,
        'line_total' => 1000,
    ]);

    $grn = Grn::withoutGlobalScopes()->create([
        'organization_id' => $organization->id,
        'purchase_order_id' => $po->id,
        'number' => 'GRN-FLOW-001',
        'status' => 'received',
        'received_at' => now(),
    ]);

    expect($grn->purchase_order_id)->toBe($po->id);

    $invoice = Invoice::withoutGlobalScopes()->create([
        'organization_id' => $organization->id,
        'purchase_order_id' => $po->id,
        'grn_id' => $grn->id,
        'number' => 'INV-FLOW-001',
        'status' => 'approved',
        'currency' => 'USD',
        'subtotal' => 1000,
        'tax_type' => 'GST',
        'tax_rate' => 15,
        'tax_total' => 150,
        'total' => 1150,
        'issued_at' => now(),
    ]);

    $payment = Payment::withoutGlobalScopes()->create([
        'organization_id' => $organization->id,
        'invoice_id' => $invoice->id,
        'reference' => 'PAY-FLOW-001',
        'status' => 'paid',
        'method' => 'bank_transfer',
        'currency' => 'USD',
        'amount' => 1150,
        'paid_at' => now(),
    ]);

    expect($payment->invoice_id)->toBe($invoice->id)
        ->and((float) $payment->amount)->toBe(1150.0)
        ->and($line->purchase_order_id)->toBe($po->id);
});
