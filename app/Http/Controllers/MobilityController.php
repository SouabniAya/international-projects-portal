<?php

namespace App\Http\Controllers;

use App\Models\MobilityOpportunity;
use Carbon\Carbon;
use App\Models\FundingProgramme;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MobilityController extends Controller
{
    private const TYPE_LABELS = [
        'outgoing_student' => 'Outgoing Student Mobility',
        'incoming_student' => 'Incoming Student Mobility',
        'staff'            => 'Staff Mobility',
        'researcher'       => 'Researcher Mobility',
        'internship'       => 'Internship',
        'summer_school'    => 'Summer School',
        'scientific_stay'  => 'Scientific Stay',
        'scholarship'      => 'Scholarship',
    ];

    public function index()
    {
        $opportunities = MobilityOpportunity::with(['translations', 'programme.translations'])
            ->where('publicationStatus', 'published')
            ->orderByDesc('applicationDeadline')
            ->get()
            ->map(fn ($m) => $this->mapForCard($m));

        return view('mobility.mobility', ['opportunities' => $opportunities]);
    }

    public function show($id)
    {
        $mobility = MobilityOpportunity::with(['translations', 'programme.translations', 'hostPartner', 'documents.document'])
            ->findOrFail($id);

        return view('mobility.mobility-details', [
            'm' => $mobility,
            'title' => $this->mobilityTitle($mobility),
            'direction' => $this->direction($mobility->mobilityType),
            'status' => $this->status($mobility->applicationDeadline),
            'programmeName' => $mobility->programme?->translation()?->programName,
        ]);
    }

    private function mapForCard(MobilityOpportunity $m): array
    {
        $programmeName = $m->programme?->translation()?->programName;

        return [
            'id' => $m->mobilityID,
            'title' => $this->mobilityTitle($m),
            'programme' => $programmeName,
            'sub' => Carbon::parse($m->startDate)->translatedFormat('F Y'),
            'university' => $m->hostingEstablishment,
            'city' => $m->city,
            'direction' => $this->direction($m->mobilityType),
            'status' => $this->status($m->applicationDeadline),
            'tags' => array_filter([$programmeName, $this->mobilityTitle($m)]),
            'deadline' => Carbon::parse($m->applicationDeadline)->format('M j, Y'),
        ];
    }

    private function mobilityTitle(MobilityOpportunity $mobility): string
    {
        $title = trim((string) ($mobility->translation()?->title ?? ''));

        if ($title !== '') {
            return $title;
        }

        $fallback = $this->typeLabel($mobility->mobilityType);

        return $mobility->hostingEstablishment
            ? $fallback . ' – ' . $mobility->hostingEstablishment
            : $fallback;
    }

    private function typeLabel(?string $type): string
    {
        return self::TYPE_LABELS[$type] ?? 'Mobility Opportunity';
    }

    private function direction(?string $type): string
    {
        if (str_starts_with((string) $type, 'outgoing')) return 'Outgoing';
        if (str_starts_with((string) $type, 'incoming')) return 'Incoming';
        return 'Outgoing';
    }

    private function status($deadline): string
    {
        $deadline = Carbon::parse($deadline);
        if ($deadline->isPast()) return 'Closed';
        if ($deadline->diffInDays(now()) <= 14) return 'Open Soon';
        return 'Open';
    }

    // ------------------------------------------------------------
    // Admin (admin/mobility.blade.php)
    // ------------------------------------------------------------

    public function adminIndex(Request $request): View
    {
        $locale=app()->getLocale(); $search=trim((string)$request->query('search',''));
        $programID=$request->filled('programID')?(int)$request->query('programID'):null;
        $direction=$request->query('direction'); $status=$request->query('status'); $type=$request->query('type'); $year=$request->query('year'); $sort=$request->query('sort','newest');
        $query=MobilityOpportunity::with(['translations'=>fn($q)=>$q->whereIn('languageCode',[$locale,'en']),'programme.translations'=>fn($q)=>$q->whereIn('languageCode',[$locale,'en'])]);
        if($search!=='') $query->where(function($q)use($search){$q->where('hostingEstablishment','like',"%{$search}%")->orWhere('city','like',"%{$search}%")->orWhereHas('translations',fn($t)=>$t->where('applicationProcess','like',"%{$search}%"));});
        if($programID)$query->where('programID',$programID);
        if(in_array($type,self::TYPE_LABELS?array_keys(self::TYPE_LABELS):[],true))$query->where('mobilityType',$type);
        if(in_array($direction,['Outgoing','Incoming'],true))$query->where(function($q)use($direction){if($direction==='Outgoing')$q->where('mobilityType','like','outgoing%')->orWhereNotIn('mobilityType',['incoming_student']);else $q->where('mobilityType','incoming_student');});
        if($year && preg_match('/^\d{4}$/',(string)$year))$query->whereYear('startDate',(int)$year);
        if($status==='closed')$query->whereDate('applicationDeadline','<',now()->toDateString()); elseif($status==='open')$query->whereDate('applicationDeadline','>=',now()->toDateString());
        match($sort){ 'oldest'=>$query->orderBy('startDate'),'deadline'=>$query->orderBy('applicationDeadline'),default=>$query->orderByDesc('startDate') };
        $opportunities=$query->paginate(5)->withQueryString();
        $opportunities->through(fn(MobilityOpportunity $m)=>['id'=>$m->mobilityID,'title'=>$this->mobilityTitle($m),'ref'=>'MOB-'.str_pad((string)$m->mobilityID,6,'0',STR_PAD_LEFT),'programme'=>$m->programme?->translation()?->programName??'Unclassified','direction'=>$this->direction($m->mobilityType),'status'=>$this->status($m->applicationDeadline),'opening'=>Carbon::parse($m->startDate)->format('M j, Y'),'deadline'=>Carbon::parse($m->applicationDeadline)->format('M j, Y')]);
        $programmes=FundingProgramme::with(['translations'=>fn($q)=>$q->whereIn('languageCode',[$locale,'en'])])->get();
        $years=MobilityOpportunity::selectRaw('YEAR(startDate) year')->whereNotNull('startDate')->distinct()->orderByDesc('year')->pluck('year');
        return view('admin.mobility',compact('opportunities','programmes','years','search','programID','direction','status','type','year','sort'));
    }

    public function adminCreate(): View
    {
        $locale=app()->getLocale(); $programmes=FundingProgramme::with(['translations'=>fn($q)=>$q->whereIn('languageCode',[$locale,'en'])])->get();
        return view('admin.mobility-create',compact('programmes'));
    }

    public function adminExport(): StreamedResponse
    {
        $items=MobilityOpportunity::with('programme.translations')->orderByDesc('startDate')->get();
        return response()->streamDownload(function()use($items){$out=fopen('php://output','w');fputcsv($out,['ID','Type','Host','City','Status','Start Date','Deadline']);foreach($items as $m)fputcsv($out,[$m->mobilityID,$this->typeLabel($m->mobilityType),$m->hostingEstablishment,$m->city,$this->status($m->applicationDeadline),$m->startDate?->format('Y-m-d'),$m->applicationDeadline?->format('Y-m-d')]);fclose($out);},'mobility.csv',['Content-Type'=>'text/csv']);
    }

    public function adminStore(\App\Http\Requests\Admin\StoreMobilityRequest $request)
    {
        $validated = $request->validated();
        $translation = $validated['translation'];
        unset($validated['translation']);

        $mobility = MobilityOpportunity::create($validated + [
            'publicationStatus' => $validated['publicationStatus'] ?? 'draft',
        ]);

        $mobility->translations()->create([
            'languageCode' => app()->getLocale(),
            'title' => $translation['title'] ?? null,
            ...$translation,
        ]);

        return redirect()->route('admin.mobility')->with('success', 'Mobility opportunity created.');
    }

    public function adminUpdate(\App\Http\Requests\Admin\UpdateMobilityRequest $request, MobilityOpportunity $mobility)
    {
        $validated = $request->validated();
        $translation = $validated['translation'] ?? null;
        unset($validated['translation']);

        $mobility->update($validated);

        if ($translation) {
            $mobility->translations()->updateOrCreate(
                ['languageCode' => app()->getLocale()],
                [
                    'title' => $translation['title'] ?? null,
                    ...$translation,
                ]
            );
        }

        return redirect()->route('admin.mobility')->with('success', 'Mobility opportunity updated.');
    }

    public function adminDestroy(MobilityOpportunity $mobility)
    {
        $mobility->delete();

        return redirect()->route('admin.mobility')->with('success', 'Mobility opportunity deleted.');
    }

    public function adminShow($id)
    {
        $mobility = MobilityOpportunity::with(['translations', 'programme.translations'])
            ->findOrFail($id);

        $info = collect([
            ['label' => 'Programme', 'value' => $mobility->programme?->translation()?->programName],
            ['label' => 'Target Audience', 'value' => $mobility->targetAudience],
            ['label' => 'Places Available', 'value' => $mobility->placesAvailable],
            ['label' => 'Required Language Skills', 'value' => $mobility->requiredLanguageSkills],
            ['label' => 'Funding Available', 'value' => $mobility->fundingAvailable],
            ['label' => 'Contact', 'value' => $mobility->contact],
        ])->filter(fn ($row) => !empty($row['value']));

        return view('admin.mobility-details', [
            'mobility' => $mobility,
            'title' => $this->mobilityTitle($mobility),
            'direction' => $this->direction($mobility->mobilityType),
            'status' => $this->status($mobility->applicationDeadline),
            'info' => $info,
        ]);
    }
}