<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFundingProgrammeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'officialWebsite' => ['nullable', 'url', 'max:255'],

            'translation' => ['nullable', 'array'],
            'translation.programName' => ['required_with:translation', 'string', 'max:150'],
            'translation.description' => ['nullable', 'string'],
        ];
    }
}
