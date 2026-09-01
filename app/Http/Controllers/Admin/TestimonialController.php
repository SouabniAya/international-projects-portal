<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimony;
use App\Models\TestimonyTranslation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(Request $request): View
    {
        $locale = app()->getLocale();
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', 'all');

        $query = Testimony::query()
            ->with(['translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en'])])
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('authorName', 'like', "%{$search}%")
                        ->orWhere('authorRole', 'like', "%{$search}%")
                        ->orWhereHas('translations', function ($translationQuery) use ($search) {
                            $translationQuery->where('content', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status !== 'all', function ($q) use ($status) {
                $q->where('status', $status === 'approved' ? 'approved' : ($status === 'pending' ? 'pending' : 'rejected'));
            });

        $items = $query->orderByDesc('date')->get()->map(function (Testimony $testimony) use ($locale) {
            $translation = $testimony->translations->firstWhere('languageCode', $locale)
                ?? $testimony->translations->firstWhere('languageCode', 'en')
                ?? $testimony->translations->first();

            return [
                'id' => $testimony->testimonyID,
                'author' => $testimony->authorName,
                'role' => $testimony->authorRole ?? '—',
                'content' => $translation?->content ?? '—',
                'status' => $testimony->status,
                'status_label' => match ($testimony->status) {
                    'approved' => 'Published',
                    'rejected' => 'Rejected',
                    default => 'Pending',
                },
                'date' => $testimony->date ? \Carbon\Carbon::parse($testimony->date)->format('j M Y') : '—',
            ];
        });

        $page = max(1, (int) $request->query('page', 1));
        $perPage = 10;
        $total = $items->count();

        $pagedItems = new LengthAwarePaginator(
            $items->slice(($page - 1) * $perPage, $perPage)->values(),
            $total,
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('admin.testimonials', [
            'testimonials' => $pagedItems,
            'filters' => [
                'search' => $search,
                'status' => $status,
            ],
        ]);
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:approved,pending,rejected'],
        ]);

        $testimony = Testimony::findOrFail($id);
        $testimony->status = $validated['status'];
        $testimony->reviewedByUserID = auth('admin')->id();
        $testimony->save();

        return redirect()->route('admin.testimonials')->with('success', 'Testimonial status updated successfully.');
    }
}
