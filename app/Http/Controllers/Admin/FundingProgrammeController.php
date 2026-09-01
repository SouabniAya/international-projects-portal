<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFundingProgrammeRequest;
use App\Http\Requests\Admin\UpdateFundingProgrammeRequest;
use App\Models\FundingProgramme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FundingProgrammeController extends Controller
{
    /**
     * NOTE — schema gap (flagged in the batch handover): the FundingProgramme
     * table only has `programID` + `officialWebsite`, and its translation
     * only has `programName` + `description`. This page's design expects a
     * funding body name, a programme "type" category, and a logo/flag per
     * programme, none of which exist anywhere in the schema (they aren't
     * on Partner or anywhere else either). Those three fields are left as
     * placeholders ('—' / a fallback icon) below rather than invented.
     * "Active Calls", "Total Budget" and "Year" ARE real, derived from the
     * programme's actual CallForProposal records.
     */
    public function index(Request $request): View
    {
        $locale = app()->getLocale();

        $programmes = FundingProgramme::query()
            ->with([
                'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
                'calls',
            ])
            ->get()
            ->map(function (FundingProgramme $p) {
                $calls = $p->calls;
                $openCalls = $calls->whereIn('status', ['open', 'closing_soon'])->count();
                $totalBudget = $calls->sum('budget');
                $years = $calls->isNotEmpty()
                    ? $calls->min('openingDate')?->format('Y') . ' - ' . $calls->max('deadline')?->format('Y')
                    : '—';

                $programmeStatus = match (true) {
                    $calls->whereIn('status', ['open', 'closing_soon'])->isNotEmpty() => 'Active',
                    $calls->where('status', 'upcoming')->isNotEmpty() && $openCalls === 0 => 'Upcoming',
                    default => $calls->isEmpty() ? 'Upcoming' : 'Closed',
                };

                return [
                    'id' => $p->programID,
                    'name' => $p->translation()?->programName ?? 'Unnamed programme',
                    'subname' => \Illuminate\Support\Str::limit($p->translation()?->description ?? '', 80),
                    'flag' => 'images/logoEsi.png',
                    'body' => '—',
                    'type' => '—',
                    'active_calls' => $openCalls,
                    'budget' => $totalBudget > 0 ? '€' . number_format((float) $totalBudget, 0, ',', ',') : '—',
                    'years' => $years,
                    'status' => $programmeStatus,
                ];
            });

        $allCalls = \App\Models\CallForProposal::all();

        $summary = [
            'total' => $programmes->count(),
            'active' => $programmes->where('status', 'Active')->count(),
            'upcoming' => $programmes->where('status', 'Upcoming')->count(),
            'closed' => $programmes->where('status', 'Closed')->count(),
            'total_budget' => $allCalls->sum('budget') > 0
                ? '€' . number_format((float) $allCalls->sum('budget'), 0, ',', ',')
                : '—',
        ];

        // "Top Funding Bodies" has no data source at all — no funding-body
        // concept exists anywhere in the schema. Left empty rather than
        // invented; the panel will just show nothing until/unless a real
        // funding-body field is added somewhere.
        $topFundingBodies = [];

        return view('admin.funding-programmes', compact('programmes', 'summary', 'topFundingBodies'));
    }

    public function create(): View
    {
        return view('admin.funding-programmes.create', ['programme' => null]);
    }

    public function edit(int $id): View
    {
        return view('admin.funding-programmes.create', [
            'programme' => FundingProgramme::with('translations')->findOrFail($id),
        ]);
    }

    public function store(StoreFundingProgrammeRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $translation = $validated['translation'];
        unset($validated['translation']);

        $programme = FundingProgramme::create($validated);

        $programme->translations()->create([
            'languageCode' => app()->getLocale(),
            ...$translation,
        ]);

        return redirect()->route('admin.funding-programmes')->with('success', 'Funding programme created.');
    }

    public function update(UpdateFundingProgrammeRequest $request, int $id): RedirectResponse
    {
        $programme = FundingProgramme::findOrFail($id);

        $validated = $request->validated();
        $translation = $validated['translation'] ?? null;
        unset($validated['translation']);

        $programme->update($validated);

        if ($translation) {
            $programme->translations()->updateOrCreate(
                ['languageCode' => app()->getLocale()],
                $translation
            );
        }

        return redirect()->route('admin.funding-programmes')->with('success', 'Funding programme updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        FundingProgramme::findOrFail($id)->delete();

        return redirect()->route('admin.funding-programmes')->with('success', 'Funding programme deleted.');
    }
}
