<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuotationRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'service_needed' => 'required|string|max:255',
            'project_location' => 'required|string|max:255',
            'budget' => 'nullable|string|max:100',
            'timeline' => 'nullable|string|max:100',
            'description' => 'required|string|max:10000',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip|max:10240',
        ];
    }
}
