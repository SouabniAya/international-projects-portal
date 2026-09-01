<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\CallForProposal;
use App\Models\Event;
use App\Models\News;
use App\Models\Partner;
use App\Models\Project;
use Carbon\Carbon;
use App\Models\HomeNewsHighlight;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

        $news = [];
        if (Schema::hasTable('HomeNewsHighlight') && Schema::hasTable('News')) {
            $news = HomeNewsHighlight::with('news.translations')
                ->whereHas('news', function ($query) {
                    $query->where('publicationStatus', 'published');
                })
                ->orderBy('displayOrder')
                ->get()
                ->map(function ($highlight) {
                    $item = $highlight->news;
                    $t = $item->translation();

                    return [
                        'title' => $t->title ?? '',
                        'excerpt' => $t->content ?? '',
                        'date' => $item->publicationDate
                            ? Carbon::parse($item->publicationDate)->format('F d, Y')
                            : '',
                        'image' => $item->image,
                    ];
                });
        }

        $events = [];
        if (Schema::hasTable('Event')) {
            $events = Event::with('translations')
                ->where('publicationStatus', 'published')
                ->where('startDate', '>=', now())
                ->orderBy('startDate')
                ->take(3)
                ->get()
                ->map(function ($item) {
                    $t = $item->translation();
                    $start = Carbon::parse($item->startDate);
                    return [
                        'title' => $t->title ?? '',
                        'day' => $start->format('d'),
                        'month' => strtoupper($start->format('M')),
                        'location' => $item->location,
                    ];
                });
        }

        // Key figures — "Countries" counts distinct countries a partner
        // institution is based in, which is the closest real proxy for
        // "international reach" the schema supports.
        $stats = [
            'countries' => 0,
            'activeAgreements' => 0,
            'ongoingProjects' => 0,
            'partners' => 0,
        ];

        if (Schema::hasTable('Partner')) {
            $stats['countries'] = Partner::whereNotNull('countryCode')->distinct('countryCode')->count('countryCode');
            $stats['partners'] = Partner::count();
        }

        if (Schema::hasTable('Agreement')) {
            $stats['activeAgreements'] = Agreement::where('status', 'active')->count();
        }

        if (Schema::hasTable('Project')) {
            $stats['ongoingProjects'] = Project::where('projectStatus', 'ongoing')->count();
        }

        $calls = [];
        if (Schema::hasTable('CallForProposal')) {
            $calls = CallForProposal::published()
                ->whereIn('status', ['open', 'closing_soon'])
                ->with([
                    'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
                    'fundingProgramme.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
                ])
                ->orderBy('deadline')
                ->take(3)
                ->get()
                ->map(fn (CallForProposal $c) => [
                    'title' => $c->translation($locale)?->title ?? 'Untitled call',
                    'excerpt' => $c->translation($locale)?->description ?? '',
                    'status' => $c->status_label,
                    'statusClass' => \Illuminate\Support\Str::slug($c->status_label),
                    'deadline' => $c->deadline?->format('j M Y'),
                ]);
        }

        $projects = [];
        if (Schema::hasTable('Project')) {
            $projects = Project::published()
                ->with(['translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en'])])
                ->orderByDesc('startDate')
                ->take(3)
                ->get()
                ->map(fn (Project $p) => [
                    'title' => $p->translation($locale)?->title ?? $p->acronym ?? 'Untitled project',
                    'excerpt' => $p->translation($locale)?->abstract ?? '',
                    'status' => $p->status_label,
                    'statusClass' => \Illuminate\Support\Str::slug($p->status_label),
                ]);
        }

        return view('home', [
            'newsItems' => $news,
            'eventItems' => $events,
            'stats' => $stats,
            'homeCalls' => $calls,
            'homeProjects' => $projects,
        ]);
    }
}