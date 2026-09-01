<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $locale = app()->getLocale();

        $query = News::query()
            ->with([
                'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
                'project.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            ])
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = trim($request->string('search')->toString());
                $q->where(function ($inner) use ($search) {
                    $inner->where('publicationStatus', 'like', "%{$search}%")
                        ->orWhereHas('translations', fn ($t) => $t->where('title', 'like', "%{$search}%"))
                        ->orWhereHas('translations', fn ($t) => $t->where('content', 'like', "%{$search}%"));
                });
            })
            ->when($request->filled('status'), fn ($q) => $q->where('publicationStatus', $request->string('status')->toString()))
            ->orderByDesc('publicationDate');

        $news = $query->paginate(10)->withQueryString();

        return view('admin.news.index', compact('news'));
    }

    public function create(): View
    {
        return view('admin.news.create', [
            'projects' => Project::query()->orderBy('projectID')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $translation = $data['translation'];
        unset($data['translation'], $data['image_upload']);

        if ($request->hasFile('image_upload')) {
            $data['image'] = $this->storeUploadedImage($request);
        }

        $news = News::create($data);
        $news->translations()->create([
            'languageCode' => app()->getLocale(),
            ...$translation,
        ]);

        return redirect()->route('admin.news')->with('success', 'News created successfully.');
    }

    public function show(int $id): View
    {
        $locale = app()->getLocale();
        $news = News::with([
            'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            'project.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            'publisher',
        ])->findOrFail($id);

        return view('admin.news.show', compact('news'));
    }

    public function edit(int $id): View
    {
        $news = News::with('translations')->findOrFail($id);

        return view('admin.news.edit', [
            'news' => $news,
            'projects' => Project::query()->orderBy('projectID')->get(),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $news = News::findOrFail($id);
        $data = $this->validateData($request);
        $translation = $data['translation'];
        // 'image' is never in $data at all now (no longer a validated field), so
        // not choosing a new file simply never touches the existing image.
        unset($data['translation'], $data['image_upload']);

        if ($request->hasFile('image_upload')) {
            $data['image'] = $this->storeUploadedImage($request);
        }

        $news->update($data);
        $news->translations()->updateOrCreate(
            ['languageCode' => app()->getLocale()],
            $translation
        );

        return redirect()->route('admin.news.show', $news->newsID)
            ->with('success', 'News updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $news = News::findOrFail($id);
        $news->translations()->delete();
        $news->delete();

        return redirect()->route('admin.news')->with('success', 'News deleted successfully.');
    }

    private function storeUploadedImage(Request $request): string
    {
        $file = $request->file('image_upload');
        $filename = time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientOriginalName());

        // Moved straight into public/images/news so it works with the existing
        // asset($news->image) calls used across the site — no storage:link needed.
        $file->move(public_path('images/news'), $filename);

        return 'images/news/' . $filename;
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'image_upload' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'publicationDate' => ['required', 'date'],
            'projectID' => ['nullable', 'integer', 'exists:Project,projectID'],
            'mobilityID' => ['nullable', 'integer'],
            'publicationStatus' => ['required', 'in:draft,published,archived'],
            'publishedAt' => ['nullable', 'date'],
            'scheduledAt' => ['nullable', 'date'],
            'translation' => ['required', 'array'],
            'translation.title' => ['required', 'string', 'max:255'],
            'translation.content' => ['nullable', 'string'],
        ]);
    }
}