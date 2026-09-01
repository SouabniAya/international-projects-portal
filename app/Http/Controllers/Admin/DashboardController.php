<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Fixed palette for the donut chart, reused in the same order every time
    // so colors stay stable across page loads regardless of which regions
    // currently have the most partners.
    private const DONUT_COLORS = [
        'var(--color-deep-space-blue)',
        'var(--color-cerulean)',
        'var(--color-fresh-sky)',
        'var(--color-neutral-300)',
    ];

    public function index()
    {
        $countriesCount = DB::table('Partner')->distinct('countryCode')->count('countryCode');
        $partnersCount = DB::table('Partner')->where('publicationStatus', 'published')->count();
        $mobilityCount = DB::table('MobilityOpportunity')->where('publicationStatus', 'published')->count();
        $callsCount = DB::table('CallForProposal')->where('publicationStatus', 'published')->count();
        $agreementsCount = DB::table('Agreement')->where('publicationStatus', 'published')->count();
        $projectsCount = DB::table('Project')->where('publicationStatus', 'published')->count();

        $kpis = [
            ['label' => 'Countries', 'value' => $countriesCount, 'trend' => '', 'direction' => 'flat', 'icon' => 'globe'],
            ['label' => 'Partners', 'value' => $partnersCount, 'trend' => '', 'direction' => 'flat', 'icon' => 'building'],
            ['label' => 'Agreements', 'value' => $agreementsCount, 'trend' => '', 'direction' => 'flat', 'icon' => 'document'],
            ['label' => 'Projects', 'value' => $projectsCount, 'trend' => '', 'direction' => 'flat', 'icon' => 'folder'],
            ['label' => 'Mobility', 'value' => $mobilityCount, 'trend' => '', 'direction' => 'flat', 'icon' => 'plane'],
            ['label' => 'Funding Calls', 'value' => $callsCount, 'trend' => '', 'direction' => 'flat', 'icon' => 'megaphone'],
        ];

        $icons = [
            'globe' => '<circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M3 12h18M12 3c2.5 2.5 2.5 15.5 0 18M12 3c-2.5 2.5-2.5 15.5 0 18" stroke="currentColor" stroke-width="1.6"/>',
            'building' => '<rect x="4" y="3" width="16" height="18" stroke="currentColor" stroke-width="1.6"/><path d="M8 8h2M8 12h2M8 16h2M14 8h2M14 12h2M14 16h2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
            'document' => '<path d="M6 3h9l3 3v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h6M9 16h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
            'folder' => '<path d="M3 7a1 1 0 0 1 1-1h5l2 2h9a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>',
            'plane' => '<path d="M2.5 19.5 21 12 2.5 4.5 5 12l-2.5 7.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>',
            'megaphone' => '<path d="M3 10v4a1 1 0 0 0 1 1h2l9 4V5L6 9H4a1 1 0 0 0-1 1Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M19 9a4 4 0 0 1 0 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
        ];

        $dirIcon = ['up' => '↑', 'down' => '↓', 'flat' => '→'];

        // ---- Partners by Region (donut) --------------------------------
        // Partner -> country (via countryCode) -> region (via regionID)
        // -> regiontranslation (region name in the current locale).
        // leftJoin on purpose: a country/region missing a translation row
        // should still be visible (grouped as "Unknown") instead of making
        // that partner silently disappear from the totals.
        $partnersByRegion = DB::table('Partner')
            ->leftJoin('country', 'Partner.countryCode', '=', 'country.countryCode')
            ->leftJoin('region', 'country.regionID', '=', 'region.regionID')
            ->leftJoin('regiontranslation', function ($join) {
                $join->on('regiontranslation.regionID', '=', 'region.regionID')
                    ->where('regiontranslation.languageCode', app()->getLocale());
            })
            ->where('Partner.publicationStatus', 'published')
            ->select(DB::raw("COALESCE(regiontranslation.regionName, 'Unknown') as regionName"), DB::raw('count(*) as total'))
            ->groupBy('regionName')
            ->orderByDesc('total')
            ->get();

        [$donutSegments, $donutGradient] = $this->buildDonutData($partnersByRegion);

        // ---- Projects by Status (bar chart) -----------------------------
        // NOTE: verify these are the exact enum values stored in
        // Project.projectStatus (adjust the keys below if different).
        $projectsByStatus = DB::table('Project')
            ->where('publicationStatus', 'published')
            ->select('projectStatus', DB::raw('count(*) as total'))
            ->groupBy('projectStatus')
            ->pluck('total', 'projectStatus');

        $projectStatusOrder = ['proposed' => 'Proposed', 'ongoing' => 'Ongoing', 'completed' => 'Completed'];
        $maxProjectCount = max($projectsByStatus->max() ?? 0, 1);

        $projectBars = [];
        foreach ($projectStatusOrder as $key => $label) {
            $count = (int) ($projectsByStatus[$key] ?? 0);
            $projectBars[] = [
                'label' => $label,
                'value' => $count,
                'heightPct' => $count > 0 ? round(($count / $maxProjectCount) * 100) : 0,
            ];
        }

        // ---- Recently Added Partners -------------------------------------
        $recentPartners = DB::table('Partner')
            ->where('publicationStatus', 'published')
            ->orderByDesc('publishedAt')
            ->limit(4)
            ->get(['partnerName', 'city', 'countryCode', 'publishedAt'])
            ->map(fn ($p) => [
                'title' => $p->partnerName,
                'sub' => ($p->city ? $p->city . ', ' : '') . $p->countryCode
                    . ' · ' . \Carbon\Carbon::parse($p->publishedAt)->diffForHumans(),
            ]);

        // ---- Partners by Type ----------------------------------------------
        $partnersByType = DB::table('Partner')
            ->where('publicationStatus', 'published')
            ->select('establishmentType', DB::raw('count(*) as total'))
            ->groupBy('establishmentType')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($row) => [
                'title' => $row->establishmentType ?? 'Unspecified',
                'sub' => $row->total . ' partner' . ($row->total > 1 ? 's' : ''),
            ]);

        // TODO: "Recent Mobilities" widget — needs MobilityOpportunity's
        // real column list (title/date/status columns) before writing this
        // query, to avoid guessing a column name that doesn't exist.
        // $recentMobilities = DB::table('MobilityOpportunity')-> ...

        return view('admin.dashboard', compact(
            'kpis',
            'icons',
            'dirIcon',
            'donutSegments',
            'donutGradient',
            'projectBars',
            'recentPartners',
            'partnersByType'
        ));
    }

    /**
     * Turns the region counts into:
     * - $segments: [['name' => ..., 'pct' => int, 'color' => css var], ...]
     *   capped at 4 rows, with a 5th "Other" row aggregating the rest.
     * - $gradient: a ready-to-use CSS conic-gradient() value string.
     */
    private function buildDonutData($partnersByRegion): array
    {
        $total = $partnersByRegion->sum('total');

        if ($total === 0) {
            return [[], 'conic-gradient(var(--color-neutral-300) 0% 100%)'];
        }

        $top = $partnersByRegion->take(4);
        $rest = $partnersByRegion->slice(4);

        $segments = [];
        foreach ($top as $i => $row) {
            $segments[] = [
                'name' => $row->regionName,
                'pct' => round(($row->total / $total) * 100),
                'color' => self::DONUT_COLORS[$i],
            ];
        }

        if ($rest->count() > 0) {
            $otherTotal = $rest->sum('total');
            $segments[] = [
                'name' => 'Other',
                'pct' => round(($otherTotal / $total) * 100),
                'color' => self::DONUT_COLORS[3],
            ];
        }

        $gradientParts = [];
        $cursor = 0;
        foreach ($segments as $segment) {
            $start = $cursor;
            $cursor += $segment['pct'];
            $gradientParts[] = "{$segment['color']} {$start}% {$cursor}%";
        }
        // Close any rounding gap so the circle always reaches 100%.
        $gradient = 'conic-gradient(' . implode(', ', $gradientParts) . ')';

        return [$segments, $gradient];
    }
}