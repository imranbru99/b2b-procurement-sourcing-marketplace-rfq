<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use App\Modules\Suppliers\Directory\Models\SupplierCategory;
use App\Modules\Suppliers\Directory\Models\SupplierProfile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'suppliers' => $this->safeCount('supplier_profiles'),
            'rfqs' => $this->safeCount('rfqs', fn ($q) => $q->where('visibility', 'public')),
            'categories' => $this->safeCount('supplier_categories'),
            'organizations' => $this->safeCount('organizations'),
        ];

        $featuredSuppliers = collect();
        if (Schema::hasTable('supplier_profiles')) {
            $query = SupplierProfile::query()->latest('id')->limit(6);
            if (Schema::hasColumn('supplier_profiles', 'is_featured')) {
                $query->where('is_featured', true);
            }
            $featuredSuppliers = $query->get();
            if ($featuredSuppliers->isEmpty()) {
                $featuredSuppliers = SupplierProfile::query()->latest('id')->limit(6)->get();
            }
        }

        $latestRfqs = collect();
        if (Schema::hasTable('rfqs')) {
            $latestRfqs = Rfq::query()
                ->where('visibility', 'public')
                ->whereIn('status', ['open', 'published'])
                ->latest('id')
                ->limit(5)
                ->get();
        }

        $categories = collect();
        if (Schema::hasTable('supplier_categories')) {
            $categories = SupplierCategory::query()->whereNull('parent_id')->orderBy('name')->limit(8)->get();
        }

        return view('public.home', compact('stats', 'featuredSuppliers', 'latestRfqs', 'categories'));
    }

    private function safeCount(string $table, ?callable $constraint = null): int
    {
        if (! Schema::hasTable($table)) {
            return 0;
        }

        try {
            $query = DB::table($table);
            if ($constraint) {
                $constraint($query);
            }

            return (int) $query->count();
        } catch (\Throwable) {
            return 0;
        }
    }
}
