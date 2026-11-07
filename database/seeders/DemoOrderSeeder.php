<?php

namespace Database\Seeders;

use App\Modules\Operations\Logistics\Models\Shipment;
use App\Modules\Orders\Disputes\Models\Dispute;
use App\Modules\Orders\GoodsReceipt\Models\Grn;
use App\Modules\Orders\Invoicing\Models\Invoice;
use App\Modules\Orders\Payments\Models\Payment;
use App\Modules\Orders\PurchaseOrders\Models\PoItem;
use App\Modules\Orders\PurchaseOrders\Models\PurchaseOrder;
use Illuminate\Database\Seeder;

class DemoOrderSeeder extends Seeder
{
    public function run(): void
    {
        $buyer = DemoContext::organization(DemoContext::BUYER_GARMENT);
        $supplier = DemoContext::organization(DemoContext::PRIMARY_SUPPLIER);
        $logistics = DemoContext::organization(DemoContext::LOGISTICS_ORG);

        $po = PurchaseOrder::withoutGlobalScopes()->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'number' => 'PO-DEMO-1001',
            ],
            [
                'supplier_organization_id' => $supplier->id,
                'status' => 'issued',
                'currency' => 'USD',
                'subtotal' => 10000,
                'tax_total' => 1500,
                'total' => 11500,
                'issued_at' => now()->subDays(5),
            ]
        );

        PoItem::withoutGlobalScopes()->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'purchase_order_id' => $po->id,
                'description' => 'Premium cotton fabric rolls',
            ],
            [
                'quantity' => 100,
                'unit_price' => 100,
                'line_total' => 10000,
            ]
        );

        $grn = Grn::withoutGlobalScopes()->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'number' => 'GRN-DEMO-1001',
            ],
            [
                'purchase_order_id' => $po->id,
                'status' => 'received',
                'received_at' => now()->subDays(2),
            ]
        );

        $invoice = Invoice::withoutGlobalScopes()->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'number' => 'INV-DEMO-1001',
            ],
            [
                'purchase_order_id' => $po->id,
                'grn_id' => $grn->id,
                'status' => 'approved',
                'currency' => 'USD',
                'subtotal' => 10000,
                'tax_type' => 'VAT',
                'tax_rate' => 15,
                'tax_total' => 1500,
                'total' => 11500,
                'issued_at' => now()->subDay(),
            ]
        );

        Payment::withoutGlobalScopes()->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'reference' => 'PAY-DEMO-1001',
            ],
            [
                'invoice_id' => $invoice->id,
                'status' => 'paid',
                'method' => 'bank_transfer',
                'currency' => 'USD',
                'amount' => 11500,
                'paid_at' => now(),
            ]
        );

        Dispute::withoutGlobalScopes()->updateOrCreate(
            [
                'organization_id' => $buyer->id,
                'purchase_order_id' => $po->id,
            ],
            [
                'subject' => 'Demo quantity variance on GRN',
                'status' => 'open',
                'opened_at' => now()->subHours(12),
            ]
        );

        Shipment::withoutGlobalScopes()->updateOrCreate(
            [
                'organization_id' => $logistics->id,
                'tracking_number' => 'DEMO-SHP-7788',
            ],
            [
                'purchase_order_id' => $po->id,
                'status' => 'in_transit',
                'shipped_at' => now()->subDays(3),
            ]
        );
    }
}
