<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\ResolvesOrganizationScope;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexApiRequest;
use App\Http\Resources\Api\V1\SupplierResource;
use App\Modules\Suppliers\Directory\Models\SupplierProfile;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SupplierController extends Controller
{
    use ResolvesOrganizationScope;

    public function index(IndexApiRequest $request): AnonymousResourceCollection
    {
        $suppliers = $this->scopedQuery(SupplierProfile::class)
            ->latest('id')
            ->paginate($request->integer('per_page', 15));

        return SupplierResource::collection($suppliers);
    }

    public function show(SupplierProfile $supplier): SupplierResource
    {
        return new SupplierResource($supplier);
    }
}
