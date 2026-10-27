<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LiveEditorRequest extends FormRequest
{
    /**
     * Access is limited to super admins by the route middleware.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'home_stats_bar' => 'nullable|array|max:4',
            'home_stats_bar.*.value' => 'nullable|string|max:20',
            'home_stats_bar.*.label' => 'nullable|string|max:60',
            'home_careers' => 'nullable|array',
            'home_careers.title' => 'nullable|string|max:120',
            'home_careers.description' => 'nullable|string|max:400',
        ];
    }
}
