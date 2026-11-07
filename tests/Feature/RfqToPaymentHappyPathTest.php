<?php

use App\Modules\Orders\Payments\Models\Payment;
use App\Modules\Orders\PurchaseOrders\Models\PurchaseOrder;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Database\Seeders\DatabaseSeeder;

it('links seeded sourcing and order data through award to paid invoice', function () {
    $this->seed(DatabaseSeeder::class);

    $awarded = Rfq::withoutGlobalScope('organization')
        ->where('slug', 'demo-awarded-packaging-rfq')
        ->first();

    expect($awarded)->not->toBeNull()
        ->and($awarded->status)->toBe('awarded');

    $po = PurchaseOrder::withoutGlobalScopes()
        ->where('number', 'PO-DEMO-1001')
        ->first();

    expect($po)->not->toBeNull();

    $payment = Payment::withoutGlobalScopes()
        ->where('reference', 'PAY-DEMO-1001')
        ->first();

    expect($payment)->not->toBeNull()
        ->and($payment->status)->toBe('paid')
        ->and((float) $payment->amount)->toBe(11500.0);
});
