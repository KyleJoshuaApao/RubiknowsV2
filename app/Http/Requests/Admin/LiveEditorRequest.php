<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LiveEditorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'home_stats_bar' => 'nullable|array',
            'home_markets' => 'nullable|string', // Comma separated for easy input, or JSON
            'home_marquee' => 'nullable|string',
            'home_careers' => 'nullable|array',
        ];
    }
}
