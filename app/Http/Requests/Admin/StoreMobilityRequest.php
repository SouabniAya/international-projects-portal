<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreMobilityRequest extends FormRequest
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
            'placesAvailable' => ['required', 'integer', 'min:0'],
            'startDate' => ['required', 'date'],
            'endDate' => ['required', 'date', 'after:startDate'],
            'requiredLanguageSkills' => ['nullable', 'string', 'max:150'],
            'applicationDeadline' => ['required', 'date', 'before_or_equal:startDate'],
            'contact' => ['required', 'string', 'max:255'],
            'fundingAvailable' => ['nullable', 'string', 'max:100'],
            'applicationLink' => ['required', 'url', 'max:255'],
            'featured' => ['nullable', 'boolean'],
            'publicationStatus' => ['nullable', 'in:draft,scheduled,published,archived'],
            'programID' => ['nullable', 'exists:FundingProgramme,programID'],
            'countryCode' => ['nullable', 'exists:Country,countryCode'],
            'hostedByPartner' => ['nullable', 'exists:Partner,partnerID'],
            'mobilityType' => ['required', 'in:outgoing_student,incoming_student,staff,researcher,internship,summer_school,scientific_stay,scholarship'],

            'translation' => ['required', 'array'],
            'translation.title' => ['required', 'string', 'max:255'],
            'translation.conditions' => ['nullable', 'string'],
            'translation.applicationProcess' => ['required', 'string'],
            'translation.selectionCriteria' => ['nullable', 'string'],
        ];
    }
}
