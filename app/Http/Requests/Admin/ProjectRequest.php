<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'title'       => 'required|string|max:255',
            'category_id' => 'nullable|string|max:255',
            'status'      => 'nullable|string|max:255',
            'year'        => 'nullable|string|max:4',
            'location'    => 'nullable|string|max:255',
            'client'      => 'nullable|string|max:255',
            'duration'    => 'nullable|string|max:255',
            'value'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_file'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ];
    }
}
