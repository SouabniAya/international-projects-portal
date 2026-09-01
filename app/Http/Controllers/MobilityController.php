<?php

namespace App\Http\Controllers;

use App\Models\MobilityOpportunity;
use Carbon\Carbon;

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
            'title' => $this->typeLabel($mobility->mobilityType),
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
            'title' => $this->typeLabel($m->mobilityType),
            'sub' => Carbon::parse($m->startDate)->translatedFormat('F Y'),
            'university' => $m->hostingEstablishment,
            'city' => $m->city,
            'direction' => $this->direction($m->mobilityType),
            'status' => $this->status($m->applicationDeadline),
            'tags' => array_filter([$programmeName, $this->typeLabel($m->mobilityType)]),
            'deadline' => Carbon::parse($m->applicationDeadline)->format('M j, Y'),
        ];
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
}