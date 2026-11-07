<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\ResolvesOrganizationScope;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexApiRequest;
use App\Http\Resources\Api\V1\RfqResource;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RfqController extends Controller
{
    use ResolvesOrganizationScope;

    public function index(IndexApiRequest $request): AnonymousResourceCollection
    {
        $rfqs = $this->scopedQuery(Rfq::class)
            ->latest('id')
            ->paginate($request->integer('per_page', 15));

        return RfqResource::collection($rfqs);
    }

    public function show(Rfq $rfq): RfqResource
    {
        return new RfqResource($rfq);
    }
}
