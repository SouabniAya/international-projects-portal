<?php

namespace App\Http\Controllers;

use App\Models\ResearchTeam;
use App\Models\SchoolPresentation;

class PresentationController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale(); // 'en' | 'fr' | 'ar'

        // Adjust ->first() to ->find($id) if you key by a specific presentationID
        $presentation = SchoolPresentation::with('translations')->first();

        $content = optional(
            $presentation?->translations->firstWhere('languageCode', $locale)
        );

        $researchTeams = ResearchTeam::with('translations')
            ->get()
            ->map(function ($team) use ($locale) {
                $t = $team->translations->firstWhere('languageCode', $locale);
                return [
                    'name'        => $t->name ?? '',
                    'description' => $t->description ?? '',
                ];
            });

        return view('presentation', [
            'vision'                      => $content->vision ?? '',
            'internationalizationStrategy'=> $content->internationalizationStrategy ?? '',
            'missions'                    => $content->missions ?? '',
            'objectives'                  => $content->objectives ?? '',
            'teachingResearchDomains'     => $content->teachingResearchDomains ?? '',
            'partnershipBenefits'         => $content->partnershipBenefits ?? '',
            'academicCalendar'            => $content->academicCalendar ?? '',
            'registrationProcedure'       => $content->registrationProcedure ?? '',
            'researchTeams'               => $researchTeams,
        ]);
    }
}