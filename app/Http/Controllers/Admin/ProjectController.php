<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;
use App\Models\FundingProgramme;

class ProjectController extends Controller
{
    /**
     * Programme name -> fallback badge asset, used only when a project has
     * no logo of its own. The original demo referenced per-programme badge
     * files (horizon-europe-badge.png, msca-badge.png, ...) that don't
     * actually exist in public/images (only erasmus-badge.webp does), so
     * this falls back to the ESI logo instead of a broken image path.
     */
    private const FALLBACK_LOGO = 'images/logoEsi.png';

    public function index(Request $request)
{
    $search = $request->input('search');
    $programID = $request->input('programID');
    $status = $request->input('status');
    $year = $request->input('year');
    $sort = $request->input('sort', 'newest');

    $query = Project::query()
        ->withCount('partners')
        ->with(['translations', 'fundingProgramme.translations']);
    if ($search) {
        $query->whereHas('translations', function ($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%');
        });
    }

    if ($programID) {
        $query->where('programID', $programID);
    }

    if ($status) {
       $query->where('projectStatus', $status);
    }

    if ($year) {
        $query->where(function ($q) use ($year) {
            $q->whereYear('startDate', $year)
              ->orWhereYear('endDate', $year);
        });
    }

    switch ($sort) {
        case 'oldest':
            $query->orderBy('startDate', 'asc');
            break;

        case 'deadline':
            $query->orderBy('endDate', 'asc');
            break;

        case 'title':
            $query->orderBy('projectID', 'asc');
            break;

        case 'newest':
        default:
            $query->orderBy('startDate', 'desc');
            break;
    }

    $projects = $query->paginate(10)->withQueryString();
    $projects->through(function (Project $p) {
    $locale = app()->getLocale();

    return [
        'projectID' => $p->projectID,
        'title' => $p->translation($locale)?->title ?? $p->acronym ?? 'Untitled project',
        'ref' => $p->projectReference ?? '—',
        'programme' => $p->fundingProgramme?->translation($locale)?->programName ?? 'Unclassified',
        'partners' => $p->partners_count,
        'coordinator' => $p->coordinator ?? '—',
        'status' => $p->status_label,
        'start' => $p->startDate?->format('M j, Y'),
        'end' => $p->endDate?->format('M j, Y'),
        'budget' => $p->budget !== null
            ? '€' . number_format((float) $p->budget, 0, ',', ',')
            : '—',
        'logo' => $p->logo ?? self::FALLBACK_LOGO,
    ];
});
    $programmes = FundingProgramme::with('translations')->get();

    $years = Project::query()
        ->selectRaw('YEAR(startDate) as year')
        ->whereNotNull('startDate')
        ->distinct()
        ->orderByDesc('year')
        ->pluck('year');

    return view('admin.projects', compact(
        'projects',
        'programmes',
        'years',
        'search',
        'programID',
        'status',
        'year',
        'sort'
    ));
}

    public function create(): View
    {
        return view('admin.project-create', [
            'countries' => \App\Models\Country::with('translations')->orderBy('countryCode')->get(),
            'programmes' => FundingProgramme::with('translations')->get(),
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $locale = app()->getLocale();
        $projects = Project::with(['translations', 'fundingProgramme.translations'])->orderByDesc('startDate')->get();
        $filename = 'projects-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($projects, $locale) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['ID', 'Title', 'Reference', 'Programme', 'Coordinator', 'Status', 'Start date', 'End date']);
            foreach ($projects as $project) {
                fputcsv($out, [
                    $project->projectID,
                    $project->translation($locale)?->title ?? $project->acronym,
                    $project->projectReference,
                    $project->fundingProgramme?->translation($locale)?->programName,
                    $project->coordinator,
                    $project->status_label,
                    optional($project->startDate)->format('Y-m-d'),
                    optional($project->endDate)->format('Y-m-d'),
                ]);
            }
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function show(int $id): View
    {
        $locale = app()->getLocale();

        $project = Project::with([
            'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            'fundingProgramme.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            'country.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            'partners.translations',
            'documents',
            'publisher',
        ])->findOrFail($id);

        return view('admin.project-details', [
            'id' => $id,
            'project' => $project,
        ]);
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $translation = $validated['translation'];
        unset($validated['translation']);

        $project = Project::create($validated + [
            'publicationStatus' => $validated['publicationStatus'] ?? 'draft',
        ]);

        $project->translations()->create([
            'languageCode' => app()->getLocale(),
            ...$translation,
        ]);

        return redirect()->route('admin.project-details', $project->projectID)
            ->with('success', 'Project created.');
    }

    public function update(UpdateProjectRequest $request, int $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $validated = $request->validated();
        $translation = $validated['translation'] ?? null;
        unset($validated['translation']);

        $project->update($validated);

        if ($translation) {
            $project->translations()->updateOrCreate(
                ['languageCode' => app()->getLocale()],
                $translation
            );
        }

        return redirect()->route('admin.project-details', $project->projectID)
            ->with('success', 'Project updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('admin.projects')->with('success', 'Project deleted.');
    }
}
