<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agreement;
use App\Models\CallForProposal;
use App\Models\ContactRequest;
use App\Models\Document;
use App\Models\Event;
use App\Models\Faq;
use App\Models\FundingProgramme;
use App\Models\MobilityOpportunity;
use App\Models\News;
use App\Models\Partner;
use App\Models\Project;
use App\Models\SchoolPresentation;
use App\Models\Testimony;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ContentManagementController extends Controller
{
    public function index(Request $request): View
    {
        $locale = app()->getLocale();
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', 'all');
        $type = (string) $request->query('type', 'all');

        $items = $this->contentItems($locale);

        if ($search !== '') {
            $needle = mb_strtolower($search);
            $items = $items->filter(function (array $item) use ($needle): bool {
                return str_contains(mb_strtolower($item['title']), $needle)
                    || str_contains(mb_strtolower($item['type']), $needle)
                    || str_contains(mb_strtolower($item['author']), $needle);
            });
        }

        if ($status !== 'all') {
            $items = $items->where('status', $status);
        }

        if ($type !== 'all') {
            $items = $items->where('type', $type);
        }

        $items = $items->values();

        $perPage = 10;
        $page = max(1, (int) $request->query('page', 1));
        $total = $items->count();

        $pagedItems = $items->slice(($page - 1) * $perPage, $perPage)->values();

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedItems,
            $total,
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        $types = $items->pluck('type')->unique()->sort()->values();

        return view('admin.content-management', [
            'contentItems' => $paginator,
            'contentTypes' => $types,
            'filters' => [
                'search' => $search,
                'status' => $status,
                'type' => $type,
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.content.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $type = (string) $request->input('content_type');
        $allowedTypes = ['News', 'Event', 'Testimonial', 'FAQ', 'School Presentation'];

        if (! in_array($type, $allowedTypes, true)) {
            return back()
                ->withInput()
                ->withErrors(['content_type' => 'This content type has its own management page.']);
        }

        $common = $request->validate([
            'content_type' => ['required', 'in:' . implode(',', $allowedTypes)],
            'language' => ['required', 'string', 'max:5', 'exists:Language,languageCode'],
            'publication_status' => ['required', 'in:draft,scheduled,published'],
            'publication_date' => ['nullable', 'date'],
            'scheduled_at' => ['nullable', 'date'],
        ]);

        $userId = auth('admin')->id();
        $language = $common['language'];
        $status = $common['publication_status'];
        $publishedAt = $status === 'published' ? now() : null;
        $scheduledAt = $status === 'scheduled' ? ($common['scheduled_at'] ?? null) : null;
        $publicationDate = $common['publication_date'] ?? now()->toDateString();

        if ($status === 'scheduled' && ! $scheduledAt) {
            return back()->withInput()->withErrors([
                'scheduled_at' => 'A scheduled publication date is required when status is Scheduled.',
            ]);
        }

        DB::transaction(function () use (
            $request,
            $type,
            $language,
            $status,
            $publishedAt,
            $scheduledAt,
            $publicationDate,
            $userId
        ): void {
            if ($type === 'News') {
                $data = $request->validate([
                    'title' => ['required', 'string', 'max:255'],
                    'content' => ['required', 'string'],
                ]);

                $news = News::create([
                    'publicationDate' => $publicationDate,
                    'publicationStatus' => $status,
                    'publishedAt' => $publishedAt,
                    'scheduledAt' => $scheduledAt,
                    'publishedByUserID' => $status === 'published' ? $userId : null,
                ]);

                $news->translations()->create([
                    'languageCode' => $language,
                    'title' => $data['title'],
                    'content' => $data['content'],
                ]);
                return;
            }

            if ($type === 'Event') {
                $data = $request->validate([
                    'title' => ['required', 'string', 'max:255'],
                    'description' => ['nullable', 'string'],
                    'event_type' => ['required', 'string', 'max:100'],
                    'start_date' => ['required', 'date'],
                    'end_date' => ['required', 'date', 'after_or_equal:start_date'],
                    'location' => ['nullable', 'string', 'max:255'],
                ]);

                $event = Event::create([
                    'eventType' => $data['event_type'],
                    'startDate' => $data['start_date'],
                    'endDate' => $data['end_date'],
                    'location' => $data['location'] ?? null,
                    'publicationStatus' => $status,
                    'publishedAt' => $publishedAt,
                    'scheduledAt' => $scheduledAt,
                    'publishedByUserID' => $status === 'published' ? $userId : null,
                ]);

                $event->translations()->create([
                    'languageCode' => $language,
                    'title' => $data['title'],
                    'description' => $data['description'] ?? null,
                ]);
                return;
            }

            if ($type === 'Testimonial') {
                $data = $request->validate([
                    'author_name' => ['required', 'string', 'max:150'],
                    'author_role' => ['required', 'string', 'max:50'],
                    'date' => ['required', 'date'],
                    'content' => ['required', 'string'],
                ]);

                $testimony = Testimony::create([
                    'authorName' => $data['author_name'],
                    'authorRole' => $data['author_role'],
                    'date' => $data['date'],
                    'status' => $status === 'published' ? 'approved' : 'pending',
                    'reviewedByUserID' => $status === 'published' ? $userId : null,
                ]);

                $testimony->translations()->create([
                    'languageCode' => $language,
                    'content' => $data['content'],
                ]);
                return;
            }

            if ($type === 'FAQ') {
                $data = $request->validate([
                    'question' => ['required', 'string', 'max:500'],
                    'answer' => ['required', 'string'],
                    'display_order' => ['nullable', 'integer', 'min:0'],
                ]);

                $faq = Faq::create([
                    'displayOrder' => $data['display_order'] ?? 0,
                ]);

                $faq->translations()->create([
                    'languageCode' => $language,
                    'question' => $data['question'],
                    'answer' => $data['answer'],
                ]);
                return;
            }

            $data = $request->validate([
                'description' => ['required', 'string'],
                'office_email' => ['nullable', 'email', 'max:255'],
                'office_phone' => ['nullable', 'string', 'max:20'],
                'office_address' => ['nullable', 'string', 'max:255'],
                'office_location' => ['nullable', 'string', 'max:255'],
            ]);

            $presentation = SchoolPresentation::create([
                'officeEmail' => $data['office_email'] ?? null,
                'officePhone' => $data['office_phone'] ?? null,
                'officeAddress' => $data['office_address'] ?? null,
                'officeLocation' => $data['office_location'] ?? null,
                'publicationDate' => $publicationDate,
                'publicationStatus' => $status,
                'publishedAt' => $publishedAt,
                'scheduledAt' => $scheduledAt,
                'publishedByUserID' => $status === 'published' ? $userId : null,
            ]);

            $presentation->translations()->create([
                'languageCode' => $language,
                'description' => $data['description'],
            ]);
        });

        return redirect()
            ->route('admin.content-management')
            ->with('success', $type . ' created successfully.');
    }

    private function contentItems(string $locale): Collection
    {
        $items = collect();

        $items = $items->merge(
            News::with(['translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']), 'publisher'])
                ->get()
                ->map(fn (News $n) => $this->row(
                    $n->translation($locale)?->title ?? 'Untitled',
                    'News',
                    $n->publicationStatus,
                    $n->publisher,
                    $n->publicationDate
                ))
        );

        $items = $items->merge(
            Event::with(['translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']), 'publisher'])
                ->get()
                ->map(fn (Event $e) => $this->row(
                    $e->translation($locale)?->title ?? 'Untitled event',
                    'Event',
                    $e->publicationStatus,
                    $e->publisher,
                    $e->startDate
                ))
        );

        $items = $items->merge(
            Project::with(['translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']), 'publisher'])
                ->get()
                ->map(fn (Project $p) => $this->row(
                    $p->translation($locale)?->title ?? $p->acronym ?? 'Untitled project',
                    'Project',
                    $p->publicationStatus,
                    $p->publisher,
                    $p->startDate
                ))
        );

        $items = $items->merge(
            CallForProposal::with(['translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']), 'publisher'])
                ->get()
                ->map(fn (CallForProposal $c) => $this->row(
                    $c->translation($locale)?->title ?? 'Untitled call',
                    'Call for Proposal',
                    $c->publicationStatus,
                    $c->publisher,
                    $c->openingDate
                ))
        );

        $items = $items->merge(
            MobilityOpportunity::with('publisher')
                ->get()
                ->map(fn (MobilityOpportunity $m) => $this->row(
                    $m->hostingEstablishment ?? 'Mobility opportunity',
                    'Mobility Opportunity',
                    $m->publicationStatus,
                    $m->publisher,
                    $m->startDate
                ))
        );

        $items = $items->merge(
            Agreement::with(['translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']), 'publisher', 'partner'])
                ->get()
                ->map(fn (Agreement $a) => $this->row(
                    $a->translation($locale)?->title ?? $a->partner?->partnerName ?? 'Untitled agreement',
                    'Partnership',
                    $a->publicationStatus,
                    $a->publisher,
                    $a->signatureDate
                ))
        );

        $items = $items->merge(
            Partner::with('publisher')
                ->get()
                ->map(fn (Partner $p) => $this->row(
                    $p->partnerName,
                    'Partner Institution',
                    $p->publicationStatus,
                    $p->publisher,
                    $p->publishedAt
                ))
        );

        $items = $items->merge(
            FundingProgramme::with(['translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en'])])
                ->get()
                ->map(fn (FundingProgramme $f) => $this->row(
                    $f->translation($locale)?->programName ?? 'Unnamed programme',
                    'Funding Programme',
                    'published',
                    null,
                    null
                ))
        );

        $items = $items->merge(
            Document::with('uploader')
                ->get()
                ->map(fn (Document $d) => $this->row(
                    $d->title,
                    'Document',
                    $d->publicationStatus,
                    $d->uploader,
                    $d->publicationDate
                ))
        );

        $items = $items->merge(
            Testimony::with('reviewer')
                ->get()
                ->map(fn (Testimony $t) => $this->row(
                    'Testimonial — ' . $t->authorName,
                    'Testimonial',
                    match ($t->status) {
                        'approved' => 'published',
                        'rejected' => 'archived',
                        default => 'draft',
                    },
                    $t->reviewer,
                    $t->date
                ))
        );

        $items = $items->merge(
            Faq::with(['translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en'])])
                ->get()
                ->map(fn (Faq $f) => $this->row(
                    $f->translation($locale)?->question ?? 'Untitled FAQ',
                    'FAQ',
                    'published',
                    null,
                    null
                ))
        );

        $items = $items->merge(
            ContactRequest::with('handler')
                ->get()
                ->map(fn (ContactRequest $c) => $this->row(
                    $c->fullName . ' — ' . \Illuminate\Support\Str::limit($c->message, 40),
                    'Contact',
                    match ($c->status) {
                        'handled' => 'published',
                        'closed' => 'archived',
                        default => 'draft',
                    },
                    $c->handler,
                    $c->submissionDate
                ))
        );

        $items = $items->merge(
            SchoolPresentation::with(['translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']), 'publisher'])
                ->get()
                ->map(fn (SchoolPresentation $s) => $this->row(
                    'School Presentation',
                    'School Presentation',
                    $s->publicationStatus,
                    $s->publisher,
                    $s->publicationDate
                ))
        );

        return $items
            ->sortByDesc(fn ($row) => $row['sort_date'] ?? '0000-00-00')
            ->values();
    }

    private function row(string $title, string $type, ?string $publicationStatus, ?User $author, $date): array
    {
        [$status, $label] = match ($publicationStatus) {
            'published' => ['approved', 'Published'],
            'scheduled' => ['pending', 'Scheduled'],
            'archived' => ['rejected', 'Archived'],
            default => ['pending', 'Draft'],
        };

        return [
            'title' => $title,
            'type' => $type,
            'status' => $status,
            'label' => $label,
            'author' => $author ? trim(($author->firstName[0] ?? '') . '. ' . $author->lastName) : '—',
            'date' => $date ? Carbon::parse($date)->format('j M Y') : '—',
            'sort_date' => $date ? Carbon::parse($date)->toDateString() : '0000-00-00',
        ];
    }
}
