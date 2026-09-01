<?php

namespace App\Http\Controllers;

use App\Models\Testimony;
use App\Models\TestimonyTranslation;
use App\Models\Country;
use App\Models\Project;
use App\Models\MobilityOpportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TestimonialController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

        $testimonials = Testimony::with('translations')
            ->approved()
            ->orderByDesc('date')
            ->get()
            ->map(function ($t) use ($locale) {
                $content = optional(
                    $t->translations->firstWhere('languageCode', $locale)
                )->content ?? '';

                return [
                    'name'    => $t->authorName,
                    'role'    => $t->authorRole,
                    'text'    => $content,
                    'photo'   => $t->photo,
                ];
            });

        return view('testimonials', ['testimonials' => $testimonials]);
    }

    public function create()
    {
        $locale = app()->getLocale();

        $countries = [];
        if (Schema::hasTable('Country')) {
            $countries = Country::with([
                'translations' => fn ($q) => $q->whereIn(
                    'languageCode',
                    [app()->getLocale(), 'en']
                )
            ])
                ->get()
                ->sortBy(
                    fn ($country) =>
                        $country->translation()?->countryName
                        ?? $country->countryCode
                )
                ->values();
        }

        // Fetch projects with translations (only published ones)
        $projects = [];
        if (Schema::hasTable('Project')) {
            $projects = Project::with([
                'translations' => fn ($q) => $q->whereIn(
                    'languageCode',
                    [$locale, 'en']
                )
            ])
                ->where('publicationStatus', 'published')
                ->get()
                ->map(function ($p) use ($locale) {
                    // Get the translation for the current locale or fall back to English
                    $translation = $p->translations->firstWhere('languageCode', $locale)
                        ?? $p->translations->firstWhere('languageCode', 'en');

                    $title = $translation?->title ?? 'Project ' . $p->projectID;

                    return [
                        'id' => $p->projectID,
                        'title' => $title,
                    ];
                })
                ->sortBy('title')
                ->values();
        }

        // Fetch mobility opportunities with translations (only published ones)
        $mobilities = [];
        if (Schema::hasTable('MobilityOpportunity')) {
            $mobilities = MobilityOpportunity::with([
                'translations' => fn ($q) => $q->whereIn(
                    'languageCode',
                    [$locale, 'en']
                )
            ])
                ->where('publicationStatus', 'published')
                ->get()
                ->map(function ($m) use ($locale) {
                    $translation = $m->translations->firstWhere('languageCode', $locale)
                        ?? $m->translations->firstWhere('languageCode', 'en');

                    $title = $translation?->title ?? 'Mobility ' . $m->mobilityID;

                    return [
                        'id' => $m->mobilityID,
                        'title' => $title,
                    ];
                })
                ->sortBy('title')
                ->values();
        }

        return view('submit-testimonial', compact('countries', 'projects', 'mobilities'));
    }

    public function store(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('TESTIMONY STORE HIT', ['payload' => $request->except('photo')]);

        $locale = app()->getLocale();

        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'author_role' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'mobility_type' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:2',
            'project_id' => 'nullable|integer|exists:Project,projectID',
            'mobility_id' => 'nullable|integer|exists:MobilityOpportunity,mobilityID',
            'content' => 'required|string|min:20|max:2000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'agree_terms' => 'required|accepted',
        ]);

        // Handle photo upload if provided
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('testimonials', 'public');
        }

        // Create testimony record with pending status (requires admin approval)
        $testimony = Testimony::create([
            'authorName' => $validated['author_name'],
            'authorRole' => $validated['author_role'],
            'photo' => $photoPath,
            'date' => now(),
            'projectID' => $validated['project_id'] ?? null,
            'mobilityID' => $validated['mobility_id'] ?? null,
            'status' => 'pending', // Requires admin approval
        ]);

        \Illuminate\Support\Facades\Log::info('TESTIMONY CREATED', [
            'testimonyID' => $testimony->testimonyID,
            'exists' => $testimony->exists,
            'wasRecentlyCreated' => $testimony->wasRecentlyCreated,
        ]);

        // Create translation for the content
        TestimonyTranslation::create([
            'testimonyID' => $testimony->testimonyID,
            'languageCode' => $locale,
            'content' => $validated['content'],
        ]);

        // TODO: Store contact info securely or send notification email to admin
        // For now, we're just storing the testimonial content

        return redirect()->route('testimonials.index')
            ->with('success', __('pages.submit_testimonial.success_message'));
    }
}