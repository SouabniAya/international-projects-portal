<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAgreementRequest;
use App\Http\Requests\Admin\UpdateAgreementRequest;
use App\Models\Agreement;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AgreementController extends Controller
{
    public function index(Request $request): View
    {
        $locale = app()->getLocale();

        $query = Agreement::query()->with([
            'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            'partner.country.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
        ]);

        if ($request->filled('search')) {
            $term = trim($request->string('search')->toString());
            $query->where(function ($q) use ($term) {
                $q->where('agreementType', 'like', "%{$term}%")
                    ->orWhereHas('translations', fn ($t) => $t->where('title', 'like', "%{$term}%"))
                    ->orWhereHas('partner', fn ($p) => $p->where('partnerName', 'like', "%{$term}%"));
            });
        }

        if ($request->filled('partnerID')) {
            $query->where('partnerID', $request->integer('partnerID'));
        }

        if ($request->filled('type')) {
            $query->where('agreementType', $request->string('type')->toString());
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        $sort = $request->string('sort')->toString();
        $query->orderBy(match ($sort) {
            'oldest' => 'startDate',
            'end_asc' => 'endDate',
            'end_desc' => 'endDate',
            default => 'startDate',
        }, in_array($sort, ['oldest', 'end_asc']) ? 'asc' : 'desc');

        $agreements = $query->paginate(10)->withQueryString()->through(function (Agreement $agreement) use ($locale) {
            $partner = $agreement->partner;
            $country = $partner?->country;

            return [
                'id' => $agreement->agreementID,
                'title' => $agreement->translation($locale)?->title ?? 'Untitled agreement',
                'ref' => 'AGR-' . str_pad((string) $agreement->agreementID, 6, '0', STR_PAD_LEFT),
                'partner' => $partner?->partnerName ?? '—',
                'logo' => $partner?->logo ?: 'images/logoEsi.png',
                'country' => $country?->translation($locale)?->countryName ?? $partner?->countryCode ?? '—',
                'flag' => 'images/logoEsi.png',
                'type' => $agreement->agreementType ?? '—',
                'domain' => '—',
                'start' => $agreement->startDate?->format('M j, Y') ?? '—',
                'end' => $agreement->endDate?->format('M j, Y') ?? '—',
                'status' => $agreement->status_label,
            ];
        });

        $stats = [
            ['label' => 'Total Agreements', 'value' => Agreement::count(), 'color' => 'blue', 'icon' => 'doc'],
            ['label' => 'Active Agreements', 'value' => Agreement::where('status', 'active')->count(), 'color' => 'green', 'icon' => 'handshake'],
            ['label' => 'Expiring This Year', 'value' => Agreement::where('status', 'active')->whereYear('endDate', now()->year)->count(), 'color' => 'orange', 'icon' => 'clock'],
            ['label' => 'Expired', 'value' => Agreement::where('status', 'expired')->count(), 'color' => 'red', 'icon' => 'calendar-check'],
        ];

        $partners = Partner::orderBy('partnerName')->get(['partnerID', 'partnerName']);
        $types = Agreement::query()->whereNotNull('agreementType')->distinct()->orderBy('agreementType')->pluck('agreementType');

        return view('admin.agreements', compact('agreements', 'stats', 'partners', 'types'));
    }

    public function create(): View
    {
        return view('admin.agreements.create', [
            'agreement' => null,
            'partners' => Partner::orderBy('partnerName')->get(),
        ]);
    }

    public function export(): StreamedResponse
    {
        $locale = app()->getLocale();
        $agreements = Agreement::with(['translations', 'partner'])
            ->orderByDesc('startDate')
            ->get();

        return response()->streamDownload(function () use ($agreements, $locale) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['ID', 'Title', 'Partner', 'Type', 'Status', 'Start Date', 'End Date']);
            foreach ($agreements as $a) {
                fputcsv($out, [
                    $a->agreementID,
                    $a->translation($locale)?->title,
                    $a->partner?->partnerName,
                    $a->agreementType,
                    $a->status_label,
                    $a->startDate?->format('Y-m-d'),
                    $a->endDate?->format('Y-m-d'),
                ]);
            }
            fclose($out);
        }, 'agreements.csv', ['Content-Type' => 'text/csv']);
    }

    public function show(int $id): View
    {
        $agreement = Agreement::with(['translations', 'partner.country.translations', 'documents'])->findOrFail($id);

        return view('admin.agreement-details', compact('agreement'));
    }

    public function store(StoreAgreementRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $translation = $validated['translation'];
        unset($validated['translation']);

        $agreement = Agreement::create($validated);
        $agreement->translations()->create([
            'languageCode' => app()->getLocale(),
            ...$translation,
        ]);

        return redirect()->route('admin.agreements')->with('success', 'Agreement created.');
    }

    public function edit(int $id): View
    {
        return view('admin.agreements.create', [
            'agreement' => Agreement::with('translations')->findOrFail($id),
            'partners' => Partner::orderBy('partnerName')->get(),
        ]);
    }

    public function update(UpdateAgreementRequest $request, int $id): RedirectResponse
    {
        $agreement = Agreement::findOrFail($id);
        $validated = $request->validated();
        $translation = $validated['translation'] ?? null;
        unset($validated['translation']);

        $agreement->update($validated);

        if ($translation) {
            $agreement->translations()->updateOrCreate(
                ['languageCode' => app()->getLocale()],
                $translation
            );
        }

        return redirect()->route('admin.agreements')->with('success', 'Agreement updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        Agreement::findOrFail($id)->delete();

        return redirect()->route('admin.agreements')->with('success', 'Agreement deleted.');
    }
}
