<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function create()
    {
        return view('public.contact');
    }

    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        ContactMessage::query()->create([
            'type' => 'contact',
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'company' => $request->validated('company'),
            'phone' => $request->validated('phone'),
            'subject' => $request->validated('subject'),
            'message' => $request->validated('message'),
            'ip' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        return redirect()
            ->route('contact')
            ->with('success', __('site.contact.success'));
    }
}
