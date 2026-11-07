<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDemoRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'company' => ['required', 'string', 'max:160'],
            'phone' => ['nullable', 'string', 'max:32'],
            'role' => ['required', 'string', 'in:buyer,supplier,platform,logistics'],
            'message' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
