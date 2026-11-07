<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        if (! in_array($locale, config('marketplace.supported_locales', ['en']), true)) {
            abort(404);
        }

        session(['locale' => $locale]);

        return redirect()->back();
    }
}
