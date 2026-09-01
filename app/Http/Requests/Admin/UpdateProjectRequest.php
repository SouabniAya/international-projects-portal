<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'acronym' => ['nullable', 'string', 'max:50'],
            'projectReference' => ['nullable', 'string', 'max:100'],
            'coordinator' => ['sometimes', 'required', 'string', 'max:255'],
            'schoolRole' => ['sometimes', 'required', 'string', 'max:100'],
            'startDate' => ['sometimes', 'required', 'date'],
            'endDate' => ['sometimes', 'required', 'date', 'after:startDate'],
            'projectStatus' => ['sometimes', 'required', 'in:proposed,ongoing,completed'],
            'website' => ['nullable', 'url', 'max:255'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'featured' => ['nullable', 'boolean'],
            'publicationStatus' => ['nullable', 'in:draft,scheduled,published,archived'],
            'programID' => ['nullable', 'exists:FundingProgramme,programID'],
            'countryCode' => ['sometimes', 'required', 'exists:Country,countryCode'],

            'translation' => ['nullable', 'array'],
            'translation.title' => ['required_with:translation', 'string', 'max:255'],
            'translation.abstract' => ['nullable', 'string'],
            'translation.objectives' => ['nullable', 'string'],
            'translation.targetGroups' => ['nullable', 'string'],
            'translation.keyResults' => ['nullable', 'string'],
            'translation.publicDeliverables' => ['nullable', 'string'],
            'translation.publications' => ['nullable', 'string'],
        ];
    }
}
