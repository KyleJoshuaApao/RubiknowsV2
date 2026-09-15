<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'company_name' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'office_address' => 'nullable|string',
            'about_story_title' => 'nullable|string',
            'about_story_content' => 'nullable|string',
            'about_projects_count' => 'nullable|string',
            'about_experience_years' => 'nullable|string',
            'about_est_year' => 'nullable|string',
            'seo_description' => 'nullable|string',
            'social_facebook' => 'nullable|string',
            'social_linkedin' => 'nullable|string',
            'nvidia_nim_api_key' => 'nullable|string',
        ];
    }
}
