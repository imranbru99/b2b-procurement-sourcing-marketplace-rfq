<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\ResolvesOrganizationScope;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexApiRequest;
use App\Http\Resources\Api\V1\OrderResource;
use App\Modules\Orders\PurchaseOrders\Models\PurchaseOrder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    use ResolvesOrganizationScope;

    public function index(IndexApiRequest $request): AnonymousResourceCollection
    {
        $orders = $this->scopedQuery(PurchaseOrder::class)
            ->latest('id')
            ->paginate($request->integer('per_page', 15));

        return OrderResource::collection($orders);
    }

    public function show(PurchaseOrder $order): OrderResource
    {
        return new OrderResource($order);
    }
}
