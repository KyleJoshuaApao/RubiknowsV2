<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GalleryMediaRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:Photo,Video',
            'category' => 'required|string|max:100',
            'album_name' => 'nullable|string|max:100',
            'media_file' => ($this->isMethod('post') ? 'required' : 'nullable').'|file|mimes:jpeg,png,jpg,webp,mp4,mov|max:20480',
        ];
    }
}
