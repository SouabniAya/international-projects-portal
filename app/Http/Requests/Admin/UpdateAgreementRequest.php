<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAgreementRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'agreementType' => ['nullable', 'string', 'max:100'],
            'signatureDate' => ['required', 'date'],
            'startDate' => ['required', 'date'],
            'endDate' => ['required', 'date', 'after_or_equal:startDate'],
            'status' => ['required', 'in:active,expired'],
            'partnerID' => ['required', 'integer', 'exists:Partner,partnerID'],
            'publicationStatus' => ['required', 'in:draft,scheduled,published,archived'],
            'publishedAt' => ['nullable', 'date'],
            'scheduledAt' => ['nullable', 'date'],
            'publishedByUserID' => ['nullable', 'integer'],
            'translation' => ['nullable', 'array'],
            'translation.title' => ['required_with:translation', 'string', 'max:255'],
        ];
    }
}
