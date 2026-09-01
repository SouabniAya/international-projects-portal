<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\News;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $news = News::with('translations')
            ->where('publicationStatus', 'published')
            ->orderByDesc('publicationDate')
            ->take(3)
            ->get()
            ->map(function ($item) {
                $t = $item->translation();
                return [
                    'title' => $t->title ?? '',
                    'excerpt' => $t->content ?? '',
                    'date' => $item->publicationDate ? Carbon::parse($item->publicationDate)->format('F d, Y') : '',
                    'image' => $item->image,
                ];
            });

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

        return view('home', [
            'newsItems' => $news,
            'eventItems' => $events,
        ]);
    }
}