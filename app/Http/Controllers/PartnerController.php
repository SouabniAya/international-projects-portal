<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(Request $request): View
    {
        $locale = app()->getLocale();
        $search = trim((string) $request->query('search', ''));
        $country = $request->query('country');
        $type = $request->query('type');
        $status = $request->query('status');

        $query = Partner::query()
            ->active()
            ->with([
                'country.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
                'translations',
            ]);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('partnerName', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }
        if ($country) {
            $query->where('countryCode', $country);
        }
        if ($type) {
            $query->where('establishmentType', $type);
        }
        if ($status) {
            $query->where('partnershipStatus', $status);
        }

        $partners = $query->orderBy('partnerName')->paginate(9)->withQueryString();

        $countries = Partner::active()->with('country.translations')->get()
            ->map(fn ($p) => $p->country)
            ->filter()
            ->unique('countryCode')
            ->sortBy(fn ($c) => $c->translation()?->countryName ?? $c->countryCode)
            ->values();

        $types = Partner::active()->whereNotNull('establishmentType')->distinct()->orderBy('establishmentType')->pluck('establishmentType');

        return view('partnerships.index', compact('partners', 'countries', 'types', 'search', 'country', 'type', 'status'));
    }

    public function show(string $slug): View
    {
        $locale = app()->getLocale();

        $partners = Partner::active()->with([
            'country.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            'translations',
            'projects.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            'agreements.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
        ])->get();

        $partner = $partners->first(fn (Partner $p) => Str::slug($p->partnerName) === $slug);

        abort_unless($partner, 404);

        $translation = $partner->translations->firstWhere('languageCode', $locale)
            ?? $partner->translations->firstWhere('languageCode', 'en')
            ?? $partner->translations->first();

        $country = $partner->country?->translation($locale);

        return view('partnerships.show', [
            'partner' => [
                'id' => $partner->partnerID,
                'name' => $partner->partnerName,
                'country' => $country?->countryName ?? $partner->countryCode,
                'city' => $partner->city ?? '—',
                'type' => $partner->establishmentType ?? '—',
                'partnerSince' => ($partner->agreements->sortBy('startDate')->first()?->startDate?->format('Y')) ?? '—',
                'status' => $partner->partnershipStatus,
                'partnershipType' => $partner->partnershipType,
                'logo' => $partner->logo,
                'website' => $partner->website,
                'presentation' => $translation?->presentation ?? '',
                'projects' => $partner->projects,
                'agreements' => $partner->agreements,
            ],
        ]);
    }
}
