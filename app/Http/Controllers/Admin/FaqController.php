<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(Request $request): View
    {
        $locale = app()->getLocale();

        $query = Faq::query()
            ->with([
                'translations' => fn ($q) => $q->whereIn('languageCode', [$locale, 'en']),
            ])
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = trim($request->string('search')->toString());
                $query->whereHas('translations', function ($q) use ($term) {
                    $q->where('question', 'like', "%{$term}%")
                        ->orWhere('answer', 'like', "%{$term}%");
                });
            })
            ->orderBy('displayOrder')
            ->orderBy('faqID');

        return view('admin.faqs.index', [
            'faqs' => $query->paginate(12)->withQueryString(),
            'filters' => [
                'search' => trim((string) $request->query('search', '')),
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.faqs.form', [
            'faq' => null,
            'locale' => app()->getLocale(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'language' => ['required', 'string', 'max:5', 'exists:Language,languageCode'],
            'question' => ['required', 'string', 'max:500'],
            'answer' => ['required', 'string'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $faq = Faq::create([
            'displayOrder' => $data['display_order'] ?? 0,
        ]);

        $faq->translations()->create([
            'languageCode' => $data['language'],
            'question' => $data['question'],
            'answer' => $data['answer'],
        ]);

        return redirect()->route('admin.faqs')->with('success', 'FAQ created successfully.');
    }

    public function edit(int $id): View
    {
        $faq = Faq::with('translations')->findOrFail($id);

        return view('admin.faqs.form', [
            'faq' => $faq,
            'locale' => app()->getLocale(),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $faq = Faq::findOrFail($id);

        $data = $request->validate([
            'language' => ['required', 'string', 'max:5', 'exists:Language,languageCode'],
            'question' => ['required', 'string', 'max:500'],
            'answer' => ['required', 'string'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $faq->update([
            'displayOrder' => $data['display_order'] ?? 0,
        ]);

        $faq->translations()->updateOrCreate(
            ['languageCode' => $data['language']],
            [
                'question' => $data['question'],
                'answer' => $data['answer'],
            ]
        );

        return redirect()->route('admin.faqs')->with('success', 'FAQ updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $faq = Faq::findOrFail($id);
        $faq->translations()->delete();
        $faq->delete();

        return redirect()->route('admin.faqs')->with('success', 'FAQ deleted successfully.');
    }
}
