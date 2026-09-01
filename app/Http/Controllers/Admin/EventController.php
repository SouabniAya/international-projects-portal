<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $locale = app()->getLocale();

        $query = Event::query()
            ->with([
                'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
                'project.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            ])
            ->when($request->filled('search'), function ($q) use ($request, $locale) {
                $search = trim($request->string('search')->toString());
                $q->where(function ($inner) use ($search) {
                    $inner->where('eventType', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhereHas('translations', fn ($t) => $t->where('title', 'like', "%{$search}%"));
                });
            })
            ->when($request->filled('type'), fn ($q) => $q->where('eventType', $request->string('type')->toString()))
            ->when($request->filled('status'), fn ($q) => $q->where('publicationStatus', $request->string('status')->toString()))
            ->when($request->filled('from'), fn ($q) => $q->whereDate('startDate', '>=', $request->date('from')))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('startDate', '<=', $request->date('to')))
            ->orderByDesc('startDate');

        $events = $query->paginate(10)->withQueryString();

        $types = Event::query()->whereNotNull('eventType')->where('eventType', '<>', '')
            ->distinct()->orderBy('eventType')->pluck('eventType');

        return view('admin.events.index', compact('events', 'types'));
    }

    public function create(): View
    {
        return view('admin.events.create', [
            'projects' => Project::query()->orderBy('projectID')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $translation = $data['translation'];
        unset($data['translation']);

        $event = Event::create($data);
        $event->translations()->create([
            'languageCode' => app()->getLocale(),
            ...$translation,
        ]);

        return redirect()->route('admin.events')->with('success', 'Event created successfully.');
    }

    public function show(int $id): View
    {
        $locale = app()->getLocale();
        $event = Event::with([
            'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            'project.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            'publisher',
        ])->findOrFail($id);

        return view('admin.events.show', compact('event'));
    }

    public function edit(int $id): View
    {
        $event = Event::with('translations')->findOrFail($id);

        return view('admin.events.edit', [
            'event' => $event,
            'projects' => Project::query()->orderBy('projectID')->get(),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $event = Event::findOrFail($id);
        $data = $this->validateData($request);
        $translation = $data['translation'];
        unset($data['translation']);

        $event->update($data);
        $event->translations()->updateOrCreate(
            ['languageCode' => app()->getLocale()],
            $translation
        );

        return redirect()->route('admin.events.show', $event->eventID)
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $event = Event::findOrFail($id);
        $event->translations()->delete();
        $event->delete();

        return redirect()->route('admin.events')->with('success', 'Event deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'eventType' => ['nullable', 'string', 'max:100'],
            'startDate' => ['required', 'date'],
            'endDate' => ['nullable', 'date', 'after_or_equal:startDate'],
            'location' => ['nullable', 'string', 'max:255'],
            'projectID' => ['nullable', 'integer', 'exists:Project,projectID'],
            'publicationStatus' => ['required', 'in:draft,published,archived'],
            'publishedAt' => ['nullable', 'date'],
            'scheduledAt' => ['nullable', 'date'],
            'translation' => ['required', 'array'],
            'translation.title' => ['required', 'string', 'max:255'],
            'translation.description' => ['nullable', 'string'],
        ]);
    }
}
