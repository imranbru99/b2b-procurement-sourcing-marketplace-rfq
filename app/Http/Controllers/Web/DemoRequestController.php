<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDemoRequestRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;

class DemoRequestController extends Controller
{
    public function create()
    {
        return view('public.demo.request');
    }

    public function store(StoreDemoRequestRequest $request): RedirectResponse
    {
        $message = trim(implode("\n", array_filter([
            'Role: '.$request->validated('role'),
            $request->validated('message'),
        ])));

        ContactMessage::query()->create([
            'type' => 'demo_request',
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'company' => $request->validated('company'),
            'phone' => $request->validated('phone'),
            'subject' => 'Demo request',
            'message' => $message,
            'ip' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        return redirect()
            ->route('demo.request')
            ->with('success', __('site.demo.request_success'));
    }
}
