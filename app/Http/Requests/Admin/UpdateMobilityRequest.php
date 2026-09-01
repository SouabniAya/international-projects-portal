<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMobilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hostingEstablishment' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'targetAudience' => ['nullable', 'string', 'max:100'],
            'placesAvailable' => ['sometimes', 'required', 'integer', 'min:0'],
            'startDate' => ['sometimes', 'required', 'date'],
            'endDate' => ['sometimes', 'required', 'date', 'after:startDate'],
            'requiredLanguageSkills' => ['nullable', 'string', 'max:150'],
            'applicationDeadline' => ['sometimes', 'required', 'date', 'before_or_equal:startDate'],
            'contact' => ['sometimes', 'required', 'string', 'max:255'],
            'fundingAvailable' => ['nullable', 'string', 'max:100'],
            'applicationLink' => ['sometimes', 'required', 'url', 'max:255'],
            'featured' => ['nullable', 'boolean'],
            'publicationStatus' => ['nullable', 'in:draft,scheduled,published,archived'],
            'programID' => ['nullable', 'exists:FundingProgramme,programID'],
            'countryCode' => ['nullable', 'exists:Country,countryCode'],
            'hostedByPartner' => ['nullable', 'exists:Partner,partnerID'],
            'mobilityType' => ['sometimes', 'required', 'in:outgoing_student,incoming_student,staff,researcher,internship,summer_school,scientific_stay,scholarship'],

            'translation' => ['nullable', 'array'],
            'translation.title' => ['nullable', 'string', 'max:255'],
            'translation.conditions' => ['nullable', 'string'],
            'translation.applicationProcess' => ['required_with:translation', 'string'],
            'translation.selectionCriteria' => ['nullable', 'string'],
        ];
    }
}
