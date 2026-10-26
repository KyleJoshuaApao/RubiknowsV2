<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJobApplicationRequest extends FormRequest
{
    /** Select value for an application that is not tied to a posted job. */
    public const GENERAL_APPLICATION = 'general';

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'job_id' => [
                'required',
                Rule::when(! $this->isGeneralApplication(), [
                    // A closure lets the query builder bind the boolean; a plain
                    // ->where('is_archived', false) is stringified to '' and never matches.
                    Rule::exists('career_jobs', 'id')->where(fn ($query) => $query->where('is_archived', false)),
                ]),
            ],
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'nullable|string|max:5000',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'portfolio' => 'nullable|file|mimes:pdf,zip|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'job_id.required' => 'Please choose the position you are applying for.',
            'job_id.exists' => 'That position is no longer open. Please choose another.',
        ];
    }

    /**
     * The chosen job, or null for a general application.
     */
    public function jobId(): ?int
    {
        return $this->isGeneralApplication() ? null : (int) $this->validated('job_id');
    }

    private function isGeneralApplication(): bool
    {
        return $this->input('job_id') === self::GENERAL_APPLICATION;
    }
}
