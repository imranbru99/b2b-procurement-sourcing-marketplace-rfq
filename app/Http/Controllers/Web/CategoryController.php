<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Modules\Suppliers\Directory\Models\SupplierCategory;
use App\Modules\Suppliers\Directory\Models\SupplierProfile;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = SupplierCategory::query()->whereNull('parent_id')->orderBy('name')->get();

        return view('public.categories.index', compact('categories'));
    }

    public function show(string $slug)
    {
        $category = SupplierCategory::query()->where('slug', $slug)->firstOrFail();

        $suppliers = SupplierProfile::query()
            ->whereHas('categories', fn ($q) => $q->where('supplier_categories.id', $category->id))
            ->latest('id')
            ->paginate(12);

        return view('public.categories.show', compact('category', 'suppliers'));
    }
}
