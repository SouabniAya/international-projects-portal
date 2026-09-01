<?php

namespace App\Http\Controllers;

use App\Models\FundingProgramme;
use Illuminate\View\View;

class FundingProgrammeController extends Controller
{
    /**
     * Public "Funding Opportunities" landing page — lists funding
     * programmes (FundingProgramme), each with a count of currently open
     * calls under it. This is the page the homepage's "Find a funding
     * opportunity" quick action now points to, instead of going straight
     * to /calls. Calls for Proposals remain their own page/concept; this
     * is the higher-level "which programmes fund us" view that didn't
     * exist before.
     */
    public function index(): View
    {
        $locale = app()->getLocale();

        $programmes = FundingProgramme::with([
            'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
        ])
            ->withCount([
                'calls as open_calls_count' => fn ($q) => $q->published()->whereIn('status', ['open', 'closing_soon', 'upcoming']),
            ])
            ->get()
            ->map(fn (FundingProgramme $p) => [
                'id' => $p->programID,
                'name' => $p->translation($locale)?->programName ?? 'Unnamed programme',
                'description' => $p->translation($locale)?->description ?? '',
                'website' => $p->officialWebsite,
                'openCallsCount' => $p->open_calls_count,
            ]);

        return view('funding-programmes.index', compact('programmes'));
    }

    public function show(int $id): View
    {
        $locale = app()->getLocale();

        $programmeModel = FundingProgramme::with([
            'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
        ])->findOrFail($id);

        $openCalls = $programmeModel->calls()
            ->published()
            ->whereIn('status', ['open', 'closing_soon', 'upcoming'])
            ->with(['translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en'])])
            ->orderBy('deadline')
            ->get()
            ->map(fn ($call) => [
                'id' => $call->proposalID,
                'title' => $call->translation($locale)?->title ?? 'Untitled call',
                'type' => $call->actionType ?? '—',
                'deadline' => $call->deadline?->format('j M Y'),
                'status' => $call->status_label,
            ]);

        $programme = [
            'id' => $programmeModel->programID,
            'name' => $programmeModel->translation($locale)?->programName ?? 'Unnamed programme',
            'description' => $programmeModel->translation($locale)?->description ?? '',
            'website' => $programmeModel->officialWebsite,
            'calls' => $openCalls,
        ];

        return view('funding-programmes.show', compact('programme'));
    }
}
