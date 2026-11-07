<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Modules\Suppliers\Directory\Models\SupplierProfile;
use Illuminate\Http\Request;

class SupplierDirectoryController extends Controller
{
    public function index(Request $request)
    {
        $search = (string) $request->query('q', '');

        $suppliers = SupplierProfile::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('company_name', 'like', '%'.$search.'%')
                        ->orWhere('tagline', 'like', '%'.$search.'%')
                        ->orWhere('city', 'like', '%'.$search.'%');
                });
            })
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        return view('public.suppliers.index', compact('suppliers', 'search'));
    }

    public function show(string $slug)
    {
        $supplier = SupplierProfile::query()->where('slug', $slug)->firstOrFail();

        return view('public.suppliers.show', compact('supplier'));
    }
}
