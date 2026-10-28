<?php

namespace App\Http\Requests\Admin;

use Closure;
use Illuminate\Foundation\Http\FormRequest;

class NewsPostRequest extends FormRequest
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
            'title' => 'nullable|string|max:150',
            'body' => 'required|string|max:2000',
            'posted_at' => 'required|date',
            'facebook_url' => ['required', 'url:https', 'max:500', function (string $attribute, mixed $value, Closure $fail): void {
                $host = strtolower((string) parse_url((string) $value, PHP_URL_HOST));
                if (! preg_match('/(^|\.)(facebook\.com|fb\.com|fb\.watch)$/', $host)) {
                    $fail('Please paste the link to the post on Facebook.');
                }
            }],
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',
            'is_published' => 'boolean',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return ['body' => 'description', 'posted_at' => 'date and time', 'facebook_url' => 'Facebook link'];
    }
}
