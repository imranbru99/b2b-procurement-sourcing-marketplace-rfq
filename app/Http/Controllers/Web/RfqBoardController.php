<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Modules\Sourcing\Rfqs\Models\Rfq;

class RfqBoardController extends Controller
{
    public function index()
    {
        $rfqs = Rfq::query()
            ->where('visibility', 'public')
            ->whereIn('status', ['open', 'published'])
            ->latest('deadline')
            ->paginate(15);

        return view('public.rfqs.index', compact('rfqs'));
    }

    public function show(string $slug)
    {
        $rfq = Rfq::query()
            ->where('slug', $slug)
            ->where('visibility', 'public')
            ->whereIn('status', ['open', 'published'])
            ->firstOrFail();

        return view('public.rfqs.show', compact('rfq'));
    }
}
