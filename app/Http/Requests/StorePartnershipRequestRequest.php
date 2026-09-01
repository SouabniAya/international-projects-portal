<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePartnershipRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'requester_name' => ['required', 'string', 'max:150'],
            'requester_role' => ['nullable', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'organization_name' => ['required', 'string', 'max:255'],
            'institution_type' => ['nullable', 'string', 'max:100'],
            'website' => ['nullable', 'url', 'max:255'],
            'country' => ['required', 'exists:Country,countryCode'],
            'city' => ['nullable', 'string', 'max:100'],
            'areas_of_interest' => ['nullable', 'array'],
            'areas_of_interest.*' => ['string', 'max:100'],
            'message' => ['required', 'string'],
            'supporting_document' => ['nullable', 'file', 'max:10240', 'mimes:pdf,doc,docx'],
        ];
    }
}
