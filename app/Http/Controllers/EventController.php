<?php

namespace App\Http\Controllers;

use App\Models\ContactSubjectRouting;
use App\Models\Event;
use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $locale = app()->getLocale();

        $events = Event::published()
            ->where('endDate', '>=', now())
            ->with(['translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en'])])
            ->orderBy('startDate')
            ->get()
            ->map(fn (Event $e) => [
                'id' => $e->eventID,
                'title' => $e->translation($locale)?->title ?? 'Untitled event',
                'date' => $e->startDate?->format('j M Y'),
                'time' => $e->startDate?->format('H:i'),
                'location' => $e->location ?? '—',
                'type' => $e->eventType,
            ]);

        return view('events.index', compact('events'));
    }

    public function register(int $id): View
    {
        $locale = app()->getLocale();

        $eventModel = Event::published()->findOrFail($id);
        $title = $eventModel->translation($locale)?->title ?? 'Event';

        $subjects = ContactSubjectRouting::with('translations')
            ->get()
            ->map(fn ($subject) => [
                'code' => $subject->subjectCode,
                'label' => optional($subject->translations->firstWhere('languageCode', $locale))->subjectLabel
                    ?? optional($subject->translations->firstWhere('languageCode', 'en'))->subjectLabel
                    ?? $subject->subjectCode,
            ]);

        return view('events.register', [
            'event' => ['id' => $eventModel->eventID, 'title' => $title],
            'subjects' => $subjects,
        ]);
    }

    public function registerStore(Request $request, int $id)
    {
        $locale = app()->getLocale();
        $event = Event::published()->with(['translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en'])])->findOrFail($id);
        $title = $event->translation($locale)?->title ?? 'Event';

        $request->merge([
            'message' => trim("Event registration interest: {$title}" . "\n\n" . ($request->input('message') ?? '')),
        ]);

        return app(ContactController::class)->store($request);
    }

    public function show(int $id): View
    {
        $locale = app()->getLocale();

        $eventModel = Event::published()
            ->with([
                'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
                'project.translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            ])
            ->findOrFail($id);

        $event = [
            'id' => $eventModel->eventID,
            'title' => $eventModel->translation($locale)?->title ?? 'Untitled event',
            'date' => $eventModel->startDate?->format('j M Y'),
            'startTime' => $eventModel->startDate?->format('H:i'),
            'endDate' => $eventModel->endDate?->format('j M Y'),
            'endTime' => $eventModel->endDate?->format('H:i'),
            'location' => $eventModel->location ?? '—',
            'type' => $eventModel->eventType,
            'description' => $eventModel->translation($locale)?->description ?? '',
            'project' => $eventModel->project ? [
                'id' => $eventModel->project->projectID,
                'title' => $eventModel->project->translation($locale)?->title ?? $eventModel->project->acronym,
                'status' => $eventModel->project->status_label,
            ] : null,
        ];

        return view('events.show', compact('event'));
    }
}
