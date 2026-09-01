<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfficeHours;
use App\Models\OfficeHoursTranslation;
use App\Models\SchoolPresentation;
use App\Models\SchoolPresentationTranslation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchoolPresentationController extends Controller
{
    public function index(): View
    {
        $locale = app()->getLocale();
        $presentation = SchoolPresentation::with([
            'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            'officeHours.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
        ])->first();

        return view('admin.school-presentations.index', [
            'presentation' => $presentation,
        ]);
    }

    public function edit(): View
    {
        $locale = app()->getLocale();
        $presentation = SchoolPresentation::with([
            'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            'officeHours.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
        ])->first();

        return view('admin.school-presentations.form', [
            'presentation' => $presentation,
            'locale' => $locale,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'language' => ['required', 'string', 'max:5', 'exists:Language,languageCode'],
            'description' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'internationalizationStrategy' => ['nullable', 'string'],
            'missions' => ['nullable', 'string'],
            'objectives' => ['nullable', 'string'],
            'teachingResearchDomains' => ['nullable', 'string'],
            'partnershipBenefits' => ['nullable', 'string'],
            'academicCalendar' => ['nullable', 'string'],
            'registrationProcedure' => ['nullable', 'string'],
            'officeEmail' => ['nullable', 'email', 'max:255'],
            'officePhone' => ['nullable', 'string', 'max:50'],
            'officeAddress' => ['nullable', 'string', 'max:255'],
            'officeLocation' => ['nullable', 'string', 'max:255'],
            'officeHoursText' => ['nullable', 'string'],
        ]);

        $normalized = [];
        foreach (['description', 'vision', 'internationalizationStrategy', 'missions', 'objectives', 'teachingResearchDomains', 'partnershipBenefits', 'academicCalendar', 'registrationProcedure', 'officeAddress', 'officeLocation', 'officeHoursText'] as $field) {
            $value = $data[$field] ?? null;
            $normalized[$field] = $value === null ? '' : $value;
        }

        $presentation = SchoolPresentation::query()->firstOrCreate([]);

        $presentation->forceFill([
            'officeEmail' => $data['officeEmail'] ?? null,
            'officePhone' => $data['officePhone'] ?? null,
        ])->save();

        $translation = $presentation->translations()->firstOrNew([
            'languageCode' => $data['language'],
        ]);

        $translation->fill([
            'description' => $normalized['description'],
            'vision' => $normalized['vision'],
            'internationalizationStrategy' => $normalized['internationalizationStrategy'],
            'missions' => $normalized['missions'],
            'objectives' => $normalized['objectives'],
            'teachingResearchDomains' => $normalized['teachingResearchDomains'],
            'partnershipBenefits' => $normalized['partnershipBenefits'],
            'academicCalendar' => $normalized['academicCalendar'],
            'registrationProcedure' => $normalized['registrationProcedure'],
            'officeAddress' => $normalized['officeAddress'],
            'officeLocation' => $normalized['officeLocation'],
        ]);
        $translation->save();

        $officeHours = $presentation->officeHours()->firstOrCreate([]);
        $officeHours->translations()->updateOrCreate(
            ['languageCode' => $data['language']],
            ['hoursText' => $normalized['officeHoursText']]
        );

        return redirect()->route('admin.school-presentation')->with('success', 'School presentation updated successfully.');
    }
}
