<?php

use App\Http\Controllers\Api\V1\BidController;
use App\Http\Controllers\Api\V1\MeController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\RfqController;
use App\Http\Controllers\Api\V1\SupplierController;
use App\Modules\Orders\PurchaseOrders\Models\PurchaseOrder;
use App\Modules\Suppliers\Directory\Models\SupplierProfile;
use Illuminate\Support\Facades\Route;

Route::bind('supplier', fn (string $value) => SupplierProfile::query()
    ->withoutGlobalScope('organization')
    ->findOrFail($value));

Route::bind('order', fn (string $value) => PurchaseOrder::query()
    ->withoutGlobalScope('organization')
    ->findOrFail($value));

Route::prefix('v1')
    ->middleware('auth:sanctum')
    ->group(function (): void {
        Route::apiResource('rfqs', RfqController::class)->only(['index', 'show']);
        Route::apiResource('bids', BidController::class)->only(['index', 'show']);
        Route::apiResource('suppliers', SupplierController::class)->only(['index', 'show']);
        Route::apiResource('orders', OrderController::class)->only(['index', 'show']);
        Route::get('me', [MeController::class, 'show'])->name('api.v1.me');
    });
