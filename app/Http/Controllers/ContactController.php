<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use App\Models\ContactSubjectRouting;
use App\Models\RequesterCategory;
use App\Models\SchoolPresentation;
use App\Mail\NewContactRequestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale(); // 'en' | 'fr' | 'ar'

        $subjects = ContactSubjectRouting::with('translations')
            ->get()
            ->map(fn ($s) => [
                'code'  => $s->subjectCode,
                'label' => optional(
                    $s->translations->firstWhere('languageCode', $locale)
                )->subjectLabel ?? '',
            ]);

        $requesterTypes = RequesterCategory::with('translations')
            ->get()
            ->map(fn ($c) => [
                'code'  => $c->categoryCode,
                'label' => optional(
                    $c->translations->firstWhere('languageCode', $locale)
                )->categoryLabel ?? '',
            ]);

        // Adjust ->first() to ->find($id) if you key by a specific presentationID
        $presentation = SchoolPresentation::with(['translations', 'officeHours.translations'])
            ->first();

        $officeTranslation = optional(
            $presentation?->translations->firstWhere('languageCode', $locale)
        );

        $hoursText = optional(
            $presentation?->officeHours?->translations->firstWhere('languageCode', $locale)
        )->hoursText ?? '';

        return view('contact', [
            'subjects'       => $subjects,
            'requesterTypes' => $requesterTypes,
            'officeEmail'    => $presentation?->officeEmail,
            'officePhone'    => $presentation?->officePhone,
            'officeAddress'  => $officeTranslation->officeAddress ?? '',
            'officeLocation' => $officeTranslation->officeLocation ?? '',
            'hoursText'      => $hoursText,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:150',
            'email'          => 'required|email|max:255',
            'phone'          => 'nullable|string|max:20',
            'requester_type' => 'nullable|integer',
            'subject'        => 'required|integer',
            'message'        => 'required|string',
            'consent'        => 'required|accepted',
        ]);

        $contactRequest = ContactRequest::create([
            'fullName'              => $validated['name'],
            'email'                 => $validated['email'],
            'phone'                 => $validated['phone'] ?? null,
            'requesterCategoryCode' => $validated['requester_type'] ?? null,
            'subjectCode'           => $validated['subject'],
            'message'               => $validated['message'],
            'submissionDate'        => now(),
            'status'                => 'new',
        ]);

        $officeEmail = SchoolPresentation::first()?->officeEmail;
        if ($officeEmail) {
            Mail::to($officeEmail)->send(new NewContactRequestMail($contactRequest));
        }

        return back()->with('success', __('contact.success_message'));
    }
}