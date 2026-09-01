<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCallRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'financingOrganism' => ['nullable','string','max:255'],
            'actionType' => ['nullable','string','max:100'],
            'fundingType' => ['nullable','string','max:100'],
            'budget' => ['nullable','numeric','min:0'],
            'financingRate' => ['nullable','string','max:50'],
            'openingDate' => ['required','date'],
            'deadline' => ['required','date','after_or_equal:openingDate'],
            'linkToOfficialSource' => ['nullable','url','max:255'],
            'status' => ['required','in:upcoming,open,closing_soon,closed'],
            'publicationStatus' => ['nullable','in:draft,scheduled,published,archived'],
            'programID' => ['required','exists:FundingProgramme,programID'],
            'publishedByUserID' => ['nullable','exists:User,userID'],
            'contact' => ['nullable','string','max:255'],
            'translation' => ['required','array'],
            'translation.title' => ['required','string','max:255'],
            'translation.description' => ['nullable','string'],
            'translation.objectives' => ['nullable','string'],
            'translation.eligibleBeneficiaries' => ['nullable','string'],
        ];
    }
}
