<?php

namespace App\Http\Controllers;

use App\Models\CallForProposal;
use App\Models\FundingProgramme;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    // ------------------------------------------------------------
    // Admin (admin/calls.blade.php)
    // ------------------------------------------------------------

    public function adminIndex(Request $request): View
    {
        $locale = app()->getLocale();
        $search = trim((string) $request->query('search', ''));
        $programID = $request->filled('programID') ? (int) $request->query('programID') : null;
        $status = $request->query('status');
        $sort = $request->query('sort', 'newest');

        $query = CallForProposal::query()->with([
            'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            'fundingProgramme.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
        ]);
        if ($search !== '') $query->where(function ($q) use ($search) {
            $q->where('financingOrganism','like',"%{$search}%")
              ->orWhere('actionType','like',"%{$search}%")
              ->orWhereHas('translations', fn ($t) => $t->where('title','like',"%{$search}%"));
        });
        if ($programID) $query->where('programID', $programID);
        if (in_array($status, ['upcoming','open','closing_soon','closed'], true)) $query->where('status', $status);
        match ($sort) {
            'oldest' => $query->orderBy('openingDate'),
            'deadline' => $query->orderBy('deadline'),
            'title' => $query->orderBy('proposalID'),
            default => $query->orderByDesc('openingDate'),
        };

        $calls = $query->paginate(5)->withQueryString();
        $calls->through(fn (CallForProposal $c) => [
            'id'=>$c->proposalID, 'title'=>$c->translation($locale)?->title ?? 'Untitled call',
            'ref'=>'CFP-'.str_pad((string)$c->proposalID,6,'0',STR_PAD_LEFT), 'flag'=>'images/logoEsi.png',
            'programme'=>$c->fundingProgramme?->translation($locale)?->programName ?? 'Unclassified',
            'type'=>$c->actionType ?? '—', 'status'=>$c->status_label,
            'opening'=>$c->openingDate?->format('M j, Y'), 'deadline'=>$c->deadline?->format('M j, Y'),
        ]);
        $programmes = FundingProgramme::with(['translations'=>fn($q)=>$q->whereIn('languageCode',[$locale,'en'])])->get();
        return view('admin.calls', compact('calls','programmes','search','programID','status','sort'));
    }

    public function adminCreate(): View
    {
        $locale=app()->getLocale();
        $programmes=FundingProgramme::with(['translations'=>fn($q)=>$q->whereIn('languageCode',[$locale,'en'])])->get();
        return view('admin.call-create', compact('programmes'));
    }

    public function adminExport(): StreamedResponse
    {
        $locale=app()->getLocale(); $calls=CallForProposal::with(['translations','fundingProgramme.translations'])->orderByDesc('openingDate')->get();
        return response()->streamDownload(function() use($calls,$locale){
            $out=fopen('php://output','w'); fputcsv($out,['ID','Title','Programme','Status','Opening Date','Deadline','Budget']);
            foreach($calls as $c) fputcsv($out,[$c->proposalID,$c->translation($locale)?->title,$c->fundingProgramme?->translation($locale)?->programName,$c->status_label,$c->openingDate?->format('Y-m-d'),$c->deadline?->format('Y-m-d'),$c->budget]); fclose($out);
        },'calls.csv',['Content-Type'=>'text/csv']);
    }

    public function adminStore(\App\Http\Requests\Admin\StoreCallRequest $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();
        $translation = $validated['translation'];
        unset($validated['translation']);

        $call = CallForProposal::create($validated + [
            'publicationStatus' => $validated['publicationStatus'] ?? 'draft',
        ]);

        $call->translations()->create([
            'languageCode' => app()->getLocale(),
            ...$translation,
        ]);

        return redirect()->route('admin.calls')->with('success', 'Call for proposals created.');
    }

    public function adminUpdate(\App\Http\Requests\Admin\UpdateCallRequest $request, CallForProposal $call): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();
        $translation = $validated['translation'] ?? null;
        unset($validated['translation']);

        $call->update($validated);

        if ($translation) {
            $call->translations()->updateOrCreate(
                ['languageCode' => app()->getLocale()],
                $translation
            );
        }

        return redirect()->route('admin.calls')->with('success', 'Call for proposals updated.');
    }

    public function adminDestroy(CallForProposal $call): \Illuminate\Http\RedirectResponse
    {
        $call->delete();

        return redirect()->route('admin.calls')->with('success', 'Call for proposals deleted.');
    }

    public function adminShow($id): View
    {
        $locale = app()->getLocale();

        $call = CallForProposal::with([
            'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            'fundingProgramme.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            'documents',
        ])->findOrFail($id);

        return view('admin.call-details', compact('call'));
    }

    // ------------------------------------------------------------
    // Opportunities (admin/opportunities.blade.php)
    // ------------------------------------------------------------

    /**
     * The "Mobility Opportunities" tab on this page is a client-side-only
     * redirect to /admin/mobility (see the <script> block already in the
     * blade) — it renders no server data of its own, so only the Calls
     * side needs real data here.
     */
    public function opportunitiesIndex(Request $request): View
    {
        $locale = app()->getLocale();
        $search = trim((string) $request->query('search', ''));
        $programID = $request->integer('programID') ?: null;
        $status = $request->filled('status') ? $request->string('status')->toString() : null;
        $deadline = $request->filled('deadline') ? $request->string('deadline')->toString() : null;

        $query = CallForProposal::query()
            ->published()
            ->with([
                'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
                'fundingProgramme.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            ])
            ->search($search)
            ->programme($programID)
            ->status($status);

        if ($deadline === '7') {
            $query->whereBetween('deadline', [now()->toDateString(), now()->addDays(7)->toDateString()]);
        } elseif ($deadline === '30') {
            $query->whereBetween('deadline', [now()->toDateString(), now()->addDays(30)->toDateString()]);
        } elseif ($deadline === 'open') {
            $query->where('deadline', '>=', now()->toDateString());
        }

        $calls = $query
            ->orderBy('deadline')
            ->paginate(10)
            ->withQueryString();

        $calls->through(fn (CallForProposal $c) => [
            'id' => $c->proposalID,
            'title' => $c->translation($locale)?->title ?? 'Untitled call',
            'tag' => $c->fundingProgramme?->translation($locale)?->programName ?? 'Unclassified',
            'audience' => $c->translation($locale)?->eligibleBeneficiaries ?? '—',
            'desc' => $c->translation($locale)?->description ?? '',
            'deadline' => $c->deadline?->format('j M Y'),
            'status' => $c->status_label,
            'officialLink' => $c->linkToOfficialSource,
        ]);

        $programmes = \App\Models\FundingProgramme::with([
            'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
        ])->get()->sortBy(fn ($p) => $p->translation($locale)?->programName ?? '')->values();

        $statuses = ['open' => 'Open', 'upcoming' => 'Upcoming', 'closing_soon' => 'Closing Soon', 'closed' => 'Closed'];

        return view('admin.opportunities', compact(
            'calls', 'programmes', 'statuses', 'search', 'programID', 'status', 'deadline'
        ));
    }
}