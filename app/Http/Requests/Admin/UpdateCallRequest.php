<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCallRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'financingOrganism' => ['sometimes','nullable','string','max:255'],
            'actionType' => ['sometimes','nullable','string','max:100'],
            'fundingType' => ['sometimes','nullable','string','max:100'],
            'budget' => ['sometimes','nullable','numeric','min:0'],
            'financingRate' => ['sometimes','nullable','string','max:50'],
            'openingDate' => ['sometimes','required','date'],
            'deadline' => ['sometimes','required','date','after_or_equal:openingDate'],
            'linkToOfficialSource' => ['sometimes','nullable','url','max:255'],
            'status' => ['sometimes','required','in:upcoming,open,closing_soon,closed'],
            'publicationStatus' => ['sometimes','nullable','in:draft,scheduled,published,archived'],
            'programID' => ['sometimes','required','exists:FundingProgramme,programID'],
            'publishedByUserID' => ['sometimes','nullable','exists:User,userID'],
            'contact' => ['sometimes','nullable','string','max:255'],
            'translation' => ['nullable','array'],
            'translation.title' => ['required_with:translation','string','max:255'],
            'translation.description' => ['nullable','string'],
            'translation.objectives' => ['nullable','string'],
            'translation.eligibleBeneficiaries' => ['nullable','string'],
        ];
    }
}
