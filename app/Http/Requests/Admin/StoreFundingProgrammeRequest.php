<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreFundingProgrammeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'officialWebsite' => ['nullable', 'url', 'max:255'],

            'translation' => ['required', 'array'],
            'translation.programName' => ['required', 'string', 'max:150'],
            'translation.description' => ['nullable', 'string'],
        ];
    }
}
