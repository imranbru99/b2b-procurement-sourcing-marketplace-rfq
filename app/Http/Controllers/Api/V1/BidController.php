<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\ResolvesOrganizationScope;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexApiRequest;
use App\Http\Resources\Api\V1\BidResource;
use App\Modules\Sourcing\Bidding\Models\Bid;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BidController extends Controller
{
    use ResolvesOrganizationScope;

    public function index(IndexApiRequest $request): AnonymousResourceCollection
    {
        $bids = $this->scopedQuery(Bid::class)
            ->latest('id')
            ->paginate($request->integer('per_page', 15));

        return BidResource::collection($bids);
    }

    public function show(Bid $bid): BidResource
    {
        return new BidResource($bid);
    }
}
