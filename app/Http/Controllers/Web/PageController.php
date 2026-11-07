<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Modules\ModuleRegistry;

class PageController extends Controller
{
    public function features()
    {
        return view('public.pages.features');
    }

    public function modules()
    {
        $registry = app(ModuleRegistry::class);
        $modules = collect($registry->keys())->sort()->values()->all();

        return view('public.pages.modules', compact('modules'));
    }

    public function forBuyers()
    {
        return view('public.pages.for-buyers');
    }

    public function forSuppliers()
    {
        return view('public.pages.for-suppliers');
    }

    public function pricing()
    {
        return view('public.pages.pricing');
    }

    public function howItWorks()
    {
        return view('public.pages.how-it-works');
    }

    public function industries()
    {
        return view('public.pages.industries');
    }

    public function about()
    {
        return view('public.pages.about');
    }

    public function faq()
    {
        return view('public.pages.faq');
    }

    public function help()
    {
        return view('public.pages.help');
    }

    public function terms()
    {
        return view('public.pages.terms');
    }

    public function privacy()
    {
        return view('public.pages.privacy');
    }

    public function login()
    {
        return view('public.pages.login');
    }

    public function register()
    {
        return view('public.pages.register');
    }
}
