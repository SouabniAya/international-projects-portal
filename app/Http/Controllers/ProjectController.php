<?php

namespace App\Http\Controllers;

use App\Models\FundingProgramme;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    private const FALLBACK_LOGO = null;

    public function index(Request $request): View
{
    $locale = app()->getLocale();

    $search = $request->string('search')->trim()->toString();
    $programID = $request->input('programID');
    $status = $request->input('status');
    $year = $request->input('year');
    $sort = $request->input('sort', 'newest');

    /*
     * Programmes for the filter dropdown.
     */
    $programmes = \App\Models\FundingProgramme::with([
        'translations' => fn ($q) => $q->whereIn(
            'languageCode',
            [$locale, 'en']
        ),
    ])->get();

    /*
     * Years for the filter dropdown.
     * These come directly from Project.startDate.
     */
    $years = Project::query()
        ->whereNotNull('startDate')
        ->selectRaw('YEAR(startDate) AS year')
        ->distinct()
        ->orderByDesc('year')
        ->pluck('year');

    /*
     * Main project query.
     */
    $query = Project::query()
        ->published()
        ->withCount('partners')
        ->with([
            'translations' => fn ($q) => $q->whereIn(
                'languageCode',
                [$locale, 'en']
            ),
            'fundingProgramme.translations' => fn ($q) => $q->whereIn(
                'languageCode',
                [$locale, 'en']
            ),
            'country.translations' => fn ($q) => $q->whereIn(
                'languageCode',
                [$locale, 'en']
            ),
        ]);

    /*
     * Search.
     */
    if ($search !== '') {
        $query->where(function ($q) use ($search, $locale) {
            $q->where('projectReference', 'like', "%{$search}%")
                ->orWhere('acronym', 'like', "%{$search}%")
                ->orWhere('coordinator', 'like', "%{$search}%")
                ->orWhereHas('translations', function ($translationQuery) use (
                    $search,
                    $locale
                ) {
                    $translationQuery
                        ->whereIn('languageCode', [$locale, 'en'])
                        ->where('title', 'like', "%{$search}%");
                });
        });
    }

    /*
     * Funding programme filter.
     */
    if ($programID !== null && $programID !== '') {
        $query->where('programID', $programID);
    }

    /*
     * Status filter.
     */
    $query->status($status);

    /*
     * Year filter.
     */
    if ($year !== null && $year !== '') {
        $query->whereYear('startDate', $year);
    }

    /*
     * Sorting.
     */
    match ($sort) {
        'oldest' => $query->orderBy('startDate', 'asc'),

        'deadline' => $query
            ->orderByRaw('endDate IS NULL ASC')
            ->orderBy('endDate', 'asc'),

        'title' => $query->orderBy('acronym', 'asc'),

        default => $query->orderBy('startDate', 'desc'),
    };

    /*
     * Pagination.
     */
    $projects = $query
        ->paginate(10)
        ->withQueryString();

    /*
     * Convert database models to the exact structure
     * expected by resources/views/projects.blade.php (public).
     */
    $projects->through(function (Project $p) use ($locale) {
        $translation = $p->translation($locale);

        return [
            'id' => $p->projectID,

            'title' => $translation?->title
                ?? $p->acronym
                ?? 'Untitled project',

            'description' => $translation?->abstract ?? '',

            'programme' => $p->fundingProgramme
                ?->translation($locale)
                ?->programName
                ?? 'Unclassified',

            'country' => $p->country?->translation($locale)?->countryName
                ?? $p->countryCode
                ?? '—',

            'status' => $p->status_label,

            'logo' => $p->logo ?? self::FALLBACK_LOGO,
        ];
    });

    return view('projects', compact(
        'projects',
        'years',
        'programmes',
        'search',
        'programID',
        'status',
        'year',
        'sort'
    ));
}

  public function show(int $id): View
{
    $locale = app()->getLocale();

    $project = Project::published()->with([
        'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
        'fundingProgramme.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
        'country.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
        'partners.translations',
        'documents',
    ])->findOrFail($id);

    $translation = $project->translation($locale);
    $programme = $project->fundingProgramme?->translation($locale);
    $country = $project->country?->translation($locale);

    $objectives = collect(preg_split('/\r\n|\r|\n/', (string) ($translation?->objectives ?? '')))
        ->map(fn ($item) => trim($item))
        ->filter()
        ->values()
        ->all();

    return view('partnerships.project-details', [
        'project' => [
            'id' => $project->projectID,
            'title' => $translation?->title ?? $project->acronym ?? __('Untitled project'),
            'desc' => $translation?->abstract ?? '',
            'overview' => $translation?->abstract ?? '',
            'objectives' => $objectives,
            'programme' => $programme?->programName ?? __('Unclassified'),
            'status' => $project->status_label,
            'duration' => ($project->startDate?->format('Y') ?? '—') . ' – ' . ($project->endDate?->format('Y') ?? '—'),
            'coordinator' => $project->coordinator,
            'countries' => $country?->countryName ?? $project->countryCode,
            'partners' => $project->partners->count(),
            'website' => $project->website,
            'project' => $project,
        ],
    ]);
}
}
