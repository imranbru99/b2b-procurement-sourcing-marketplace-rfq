<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemoLoginController extends Controller
{
    public function index()
    {
        return view('public.demo.try', [
            'logins' => config('marketplace.demo_logins', []),
        ]);
    }

    public function login(Request $request, string $panel): RedirectResponse
    {
        $login = collect(config('marketplace.demo_logins', []))->firstWhere('panel', $panel);

        if (! $login) {
            abort(404);
        }

        $user = User::query()->where('email', $login['email'])->first();

        if (! $user) {
            return redirect()
                ->route('demo.try')
                ->with('error', __('site.demo.user_missing'));
        }

        Auth::login($user, remember: true);

        $request->session()->regenerate();

        return redirect()->to($login['path']);
    }
}
