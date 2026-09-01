<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PartnerManagementController extends Controller
{
    public function index(Request $request)
    {
        $locale = app()->getLocale();

        $query = DB::table('Partner')
            ->leftJoin('PartnerTranslation', function ($join) use ($locale) {
                $join->on('PartnerTranslation.partnerID', '=', 'Partner.partnerID')
                     ->where('PartnerTranslation.languageCode', '=', $locale);
            })
            ->leftJoin('Country', 'Country.countryCode', '=', 'Partner.countryCode')
            ->leftJoin('CountryTranslation', function ($join) use ($locale) {
                $join->on('CountryTranslation.countryCode', '=', 'Partner.countryCode')
                     ->where('CountryTranslation.languageCode', '=', $locale);
            })
            ->select(
                'Partner.partnerID',
                'Partner.partnerName',
                'Partner.city',
                'Partner.logo',
                'Partner.establishmentType',
                'Partner.partnershipType',
                'Partner.partnershipStatus',
                'Partner.countryCode',
                'PartnerTranslation.presentation',
                'CountryTranslation.countryName'
            )
            ->where('Partner.publicationStatus', 'published');

        // Search by partner name
        if ($request->filled('search')) {
            $query->where('Partner.partnerName', 'like', '%' . $request->input('search') . '%');
        }

        // Country filter — value is the translated country NAME, not the code,
        // so we match against CountryTranslation.countryName directly.
        if ($request->filled('country')) {
            $query->where('CountryTranslation.countryName', $request->input('country'));
        }

        if ($request->filled('establishmentType')) {
            $query->where('Partner.establishmentType', $request->input('establishmentType'));
        }

        if ($request->filled('partnershipType')) {
            $query->where('Partner.partnershipType', $request->input('partnershipType'));
        }

        if ($request->filled('partnershipStatus')) {
            $query->where('Partner.partnershipStatus', $request->input('partnershipStatus'));
        }

        // Project filter — used by the "Partners" tab on a project's detail
        // page (route('admin.partner-management', ['project' => $id])),
        // scoped through the ProjectPartner pivot table.
        if ($request->filled('project')) {
            $projectId = $request->input('project');
            $query->whereExists(function ($sub) use ($projectId) {
                $sub->select(DB::raw(1))
                    ->from('ProjectPartner')
                    ->whereColumn('ProjectPartner.partnerID', 'Partner.partnerID')
                    ->where('ProjectPartner.projectID', $projectId);
            });
        }

        // Domain filter — matches partners that cooperate in the given thematic area name
        if ($request->filled('domain')) {
            $domain = $request->input('domain');
            $query->whereExists(function ($sub) use ($domain, $locale) {
                $sub->select(DB::raw(1))
                    ->from('CooperatesIn')
                    ->join('ThematicAreaTranslation', 'ThematicAreaTranslation.areaID', '=', 'CooperatesIn.areaID')
                    ->whereColumn('CooperatesIn.partnerID', 'Partner.partnerID')
                    ->where('ThematicAreaTranslation.languageCode', $locale)
                    ->where('ThematicAreaTranslation.areaName', $domain);
            });
        }

        $sort = $request->input('sort', 'name_asc');
        match ($sort) {
            'name_desc' => $query->orderByDesc('Partner.partnerName'),
            'status'    => $query->orderBy('Partner.partnershipStatus'),
            default     => $query->orderBy('Partner.partnerName'),
        };

        $partners = $query->paginate(15)->withQueryString();

        // Attach comma-joined domain names to each partner (separate query,
        // since GROUP_CONCAT alongside the joins above would break pagination counts)
        $partnerIDs = $partners->pluck('partnerID');
        if ($partnerIDs->isNotEmpty()) {
            $domainsByPartner = DB::table('CooperatesIn')
                ->join('ThematicAreaTranslation', 'ThematicAreaTranslation.areaID', '=', 'CooperatesIn.areaID')
                ->whereIn('CooperatesIn.partnerID', $partnerIDs)
                ->where('ThematicAreaTranslation.languageCode', $locale)
                ->select('CooperatesIn.partnerID', DB::raw('GROUP_CONCAT(ThematicAreaTranslation.areaName SEPARATOR \', \') as domains'))
                ->groupBy('CooperatesIn.partnerID')
                ->pluck('domains', 'partnerID');

            $partners->getCollection()->transform(function ($p) use ($domainsByPartner) {
                $p->domains = $domainsByPartner[$p->partnerID] ?? null;
                return $p;
            });
        }

        // Filter dropdown options — these list ALL possible values (from the
        // reference tables / the same fixed lists used on the Add Partner
        // form), NOT just the values currently used by existing partners.
        // Using Partner::distinct() here would mean a filter only shows
        // options that already exist in the data (e.g. only "Spain" until
        // a partner from another country is added) — not what we want for
        // a filter, which should let you filter by anything that COULD
        // exist.
        $countries = DB::table('CountryTranslation')
            ->where('languageCode', $locale)
            ->distinct()
            ->orderBy('countryName')
            ->pluck('countryName');

        $establishmentTypes = collect([
            'University',
            'Research Institute',
            'Higher Education Institution',
            'Government Institution',
            'Non-Governmental Organization',
            'Company',
            'Other',
        ]);

        $domains = DB::table('ThematicAreaTranslation')
            ->where('languageCode', $locale)
            ->distinct()
            ->orderBy('areaName')
            ->pluck('areaName');

        $partnershipTypes = collect([
            'Bilateral Agreement',
            'Framework Agreement',
            'Memorandum of Understanding',
            'Erasmus Agreement',
            'Research Agreement',
            'Other',
        ]);

        $partnershipStatuses = collect(['pending', 'active', 'expired']);

        return view('admin.partner-management', [
            'partners'            => $partners,
            'countries'           => $countries,
            'establishmentTypes'  => $establishmentTypes,
            'domains'             => $domains,
            'partnershipTypes'    => $partnershipTypes,
            'partnershipStatuses' => $partnershipStatuses,
        ]);
    }

 public function destroy(int $partnerID)
{
    $partner = Partner::findOrFail($partnerID);

    $hasMobility = DB::table('MobilityOpportunity')
        ->where('hostedByPartner', $partnerID)
        ->exists();

    if ($hasMobility) {
        return redirect()->route('admin.partner-management')
            ->with('error', 'This partner cannot be deleted because it is linked to one or more mobility opportunities. Remove or reassign those first.');
    }

    if ($partner->logo) {
        Storage::disk('public')->delete($partner->logo);
    }

    $partner->delete();

    return redirect()->route('admin.partner-management')->with('success', 'Partner deleted.');
}

    /**
     * Add Partner form.
     * Note: $countries here is code => name (for the <select>), which is a
     * DIFFERENT shape from index()'s $countries (a flat list of names used
     * for the filter dropdown). Same variable name, different controller
     * action, different shape — this is intentional and matches what
     * partner-management-create.blade.php expects.
     */
    public function create()
    {
        $locale = app()->getLocale();

        $countries = DB::table('CountryTranslation')
            ->where('languageCode', $locale)
            ->orderBy('countryName')
            ->pluck('countryName', 'countryCode');

        $domains = DB::table('ThematicAreaTranslation')
            ->where('languageCode', $locale)
            ->orderBy('areaName')
            ->pluck('areaName', 'areaID');

        return view('admin.partner-management-create', [
            'countries' => $countries,
            'domains'   => $domains,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'partnerName'       => 'required|string|max:255',
            'city'              => 'nullable|string|max:100',
            'establishmentType' => 'nullable|string|max:100',
            'partnershipType'   => 'required|string|max:100',
            'partnershipStatus' => 'required|string|max:50',
            'countryCode'       => 'required|exists:Country,countryCode',
            'website'           => 'nullable|url|max:255',
            'areaID'            => 'nullable|exists:ThematicArea,areaID',
            'presentation'      => 'nullable|string',
            'logo'              => 'nullable|file|image|mimes:png,jpg,jpeg,webp|max:4096',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('partners/logos', 'public');
        }

        $partner = Partner::create([
            'partnerName'       => $validated['partnerName'],
            'city'              => $validated['city'] ?? null,
            'establishmentType' => $validated['establishmentType'] ?? null,
            'partnershipType'   => $validated['partnershipType'],
            'partnershipStatus' => $validated['partnershipStatus'],
            'countryCode'       => $validated['countryCode'],
            'website'           => $validated['website'] ?? null,
            'logo'              => $logoPath,
            'publicationStatus' => 'published',
            'publishedAt'       => now(),
        ]);

        // Presentation text is stored per-language in PartnerTranslation, not on Partner itself
        if (!empty($validated['presentation'])) {
            DB::table('PartnerTranslation')->insert([
                'partnerID'    => $partner->partnerID,
                'languageCode' => app()->getLocale(),
                'presentation' => $validated['presentation'],
            ]);
        }

        // Domain of cooperation is a many-to-many relation via CooperatesIn
        if (!empty($validated['areaID'])) {
            DB::table('CooperatesIn')->insert([
                'partnerID' => $partner->partnerID,
                'areaID'    => $validated['areaID'],
            ]);
        }

        return redirect()->route('admin.partner-management')->with('success', 'Partner created.');
    }

    public function show(int $partnerID)
    {
        $partner = Partner::with(['country.translations', 'translations', 'thematicAreas.translations'])
            ->findOrFail($partnerID);

        return view('admin.partner-management-show', ['partner' => $partner]);
    }

    public function edit(int $partnerID)
    {
        $locale = app()->getLocale();

        $partner = Partner::findOrFail($partnerID);

        $presentation = DB::table('PartnerTranslation')
            ->where('partnerID', $partnerID)
            ->where('languageCode', $locale)
            ->value('presentation');

        $currentAreaID = DB::table('CooperatesIn')
            ->where('partnerID', $partnerID)
            ->value('areaID');

        $countries = DB::table('CountryTranslation')
            ->where('languageCode', $locale)
            ->orderBy('countryName')
            ->pluck('countryName', 'countryCode');

        $domains = DB::table('ThematicAreaTranslation')
            ->where('languageCode', $locale)
            ->orderBy('areaName')
            ->pluck('areaName', 'areaID');

        return view('admin.partner-management-edit', [
            'partner'       => $partner,
            'presentation'  => $presentation,
            'currentAreaID' => $currentAreaID,
            'countries'     => $countries,
            'domains'       => $domains,
        ]);
    }

    public function update(Request $request, int $partnerID)
    {
        $partner = Partner::findOrFail($partnerID);

        $validated = $request->validate([
            'partnerName'       => 'required|string|max:255',
            'city'              => 'nullable|string|max:100',
            'establishmentType' => 'nullable|string|max:100',
            'partnershipType'   => 'required|string|max:100',
            'partnershipStatus' => 'required|string|max:50',
            'countryCode'       => 'required|exists:Country,countryCode',
            'website'           => 'nullable|url|max:255',
            'areaID'            => 'nullable|exists:ThematicArea,areaID',
            'presentation'      => 'nullable|string',
            'logo'              => 'nullable|file|image|mimes:png,jpg,jpeg,webp|max:4096',
        ]);

        if ($request->hasFile('logo')) {
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }
            $validated['logo'] = $request->file('logo')->store('partners/logos', 'public');
        } else {
            unset($validated['logo']);
        }

        $presentation = $validated['presentation'] ?? null;
        $areaID = $validated['areaID'] ?? null;
        unset($validated['presentation'], $validated['areaID']);

        $partner->update($validated);

        DB::table('PartnerTranslation')->updateOrInsert(
            ['partnerID' => $partnerID, 'languageCode' => app()->getLocale()],
            ['presentation' => $presentation]
        );

        DB::table('CooperatesIn')->where('partnerID', $partnerID)->delete();
        if ($areaID) {
            DB::table('CooperatesIn')->insert(['partnerID' => $partnerID, 'areaID' => $areaID]);
        }

        return redirect()->route('admin.partner-management')->with('success', 'Partner updated.');
    }
}