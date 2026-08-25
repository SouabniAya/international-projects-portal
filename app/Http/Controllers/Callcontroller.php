<?php

namespace App\Http\Controllers;

use App\Models\CallForProposal;
use App\Models\FundingProgramme;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CallController extends Controller
{
    /**
     * Calls for Proposals — list page.
     */
    public function index(Request $request): View
    {
        $locale = app()->getLocale();

        $calls = CallForProposal::query()
            ->published()
            ->status($request->string('status')->toString() ?: null)
            ->programme($request->integer('programID') ?: null)
            ->search($request->string('search')->toString() ?: null)
            ->with([
                'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
                'fundingProgramme.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            ])
            ->orderByDesc('openingDate')
            ->paginate(9)
            ->withQueryString();

        $programmes = FundingProgramme::with([
            'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
        ])->get();

        return view('calls.index', compact('calls', 'programmes'));
    }

    /**
     * Call for Proposals — detail page.
     */
    public function show(CallForProposal $call): View
    {
        $locale = app()->getLocale();

        abort_unless($call->publicationStatus === 'published', 404);

        $call->load([
            'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            'fundingProgramme.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            'documents',
            'eligibleCountries.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
        ]);

        return view('calls.show', compact('call'));
    }
}