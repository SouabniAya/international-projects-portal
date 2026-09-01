<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $locale = app()->getLocale();

        $news = News::published()
            ->with(['translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en'])])
            ->orderByDesc('publicationDate')
            ->paginate(9)
            ->withQueryString();

        $news->through(fn (News $n) => [
            'id' => $n->newsID,
            'title' => $n->translation($locale)?->title ?? 'Untitled',
            'excerpt' => \Illuminate\Support\Str::limit(
                strip_tags($n->translation($locale)?->content ?? ''),
                160
            ),
            'date' => $n->publicationDate?->format('j M Y'),
            'image' => $n->image,
        ]);

        return view('news.index', ['news' => $news]);
    }

    public function show(int $id): View
    {
        $locale = app()->getLocale();

        $newsModel = News::published()
            ->with(['translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en'])])
            ->findOrFail($id);

        $news = [
            'id' => $newsModel->newsID,
            'title' => $newsModel->translation($locale)?->title ?? 'Untitled',
            'date' => $newsModel->publicationDate?->format('j M Y'),
            'content' => $newsModel->translation($locale)?->content ?? '',
            'image' => $newsModel->image,
        ];

        return view('news.show', compact('news'));
    }
}
