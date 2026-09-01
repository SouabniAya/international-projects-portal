<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use App\Models\Document;
use App\Models\EventRegistration;
use App\Models\Partner;
use App\Models\PartnershipRequest;
use Illuminate\Http\Request;

class RequestsDocumentsController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

        $contactRequests = ContactRequest::with(['subject.translations', 'handler'])
            ->orderByDesc('submissionDate')
            ->take(5)
            ->get()
            ->map(function ($r) use ($locale) {
                $subjectLabel = optional(
                    $r->subject?->translations->firstWhere('languageCode', $locale)
                )->subjectLabel ?? '';

                return [
                    'id'       => $r->requestID,
                    'name'     => $r->fullName,
                    'email'    => $r->email,
                    'subject'  => $subjectLabel,
                    'date'     => $r->submissionDate,
                    'status'   => $r->status,
                    'assigned' => $r->handler->firstName ?? null,
                ];
            });

        $partnerRequests = PartnershipRequest::with('documents')
            ->orderByDesc('submissionDate')
            ->take(5)
            ->get()
            ->map(function ($r) {
                return [
                    'id'      => $r->requestID,
                    'name'    => $r->requesterName,
                    'email'   => $r->email,
                    'org'     => $r->organizationName,
                    'country' => strtolower($r->country),
                    'phone'   => $r->phone,
                    'docs'    => $r->documents->count(),
                    'status'  => $r->status,
                ];
            });

        $documents = Document::with('category.translations')
            ->orderByDesc('publicationDate')
            ->take(5)
            ->get()
            ->map(function ($d) use ($locale) {
                $categoryName = optional(
                    $d->category?->translations->firstWhere('languageCode', $locale)
                )->categoryName ?? '';

                return [
                    'id'         => $d->documentID,
                    'title'      => $d->title,
                    'category'   => $categoryName,
                    'date'       => \Illuminate\Support\Carbon::parse($d->publicationDate),
                    'visibility' => ucfirst($d->visibilityLevel),
                    'format'     => $d->format,
                    'size'       => $d->formatted_size,
                ];
            });

        $eventRegistrations = EventRegistration::with('event.translations')
            ->orderByDesc('submissionDate')
            ->take(5)
            ->get()
            ->map(function ($r) use ($locale) {
                $eventTitle = optional(
                    $r->event?->translations->firstWhere('languageCode', $locale)
                )->title ?? '';

                return [
                    'id'     => $r->registrationID,
                    'name'   => $r->fullName,
                    'email'  => $r->email,
                    'event'  => $eventTitle,
                    'date'   => $r->submissionDate,
                    'status' => $r->status,
                ];
            });

        return view('admin.requests-documents', [
            'contactRequests'    => $contactRequests,
            'partnerRequests'    => $partnerRequests,
            'documents'          => $documents,
            'eventRegistrations' => $eventRegistrations,
        ]);
    }

    public function showContactRequest(int $requestID)
    {
        $locale = app()->getLocale();

        $request = ContactRequest::with([
            'subject.translations',
            'requesterCategory.translations',
            'handler',
        ])->findOrFail($requestID);

        return view('admin.requests.contact-show', [
            'r' => $request,
            'subjectLabel' => optional(
                $request->subject?->translations->firstWhere('languageCode', $locale)
            )->subjectLabel ?? $request->subject?->subjectCode,
            'categoryLabel' => optional(
                $request->requesterCategory?->translations->firstWhere('languageCode', $locale)
            )->categoryLabel ?? $request->requesterCategory?->categoryCode,
        ]);
    }

    public function showPartnershipRequest(int $requestID)
    {
        $request = PartnershipRequest::with(['documents', 'handler', 'countryModel'])
            ->findOrFail($requestID);

        return view('admin.requests.partnership-show', [
            'r' => $request,
        ]);
    }

    public function approvePartnership(int $requestID)
    {
        $partnershipRequest = PartnershipRequest::findOrFail($requestID);

        // Only create the Partner the first time this request is approved —
        // re-clicking Approve on an already-accepted request (or approving
        // after a Reject) must never create a duplicate Partner row.
        if ($partnershipRequest->status !== 'accepted') {
            $this->createPartnerFromRequest($partnershipRequest);
        }

        $partnershipRequest->update([
            'status'          => 'accepted',
            'handledByUserID' => auth()->id(),
        ]);

        return back()->with('success', 'Partnership request approved and partner added.');
    }

    /**
     * BecomeAPartnerController folds fields with no dedicated PartnershipRequest
     * column (institution type, website, city) into `message` as labeled lines,
     * e.g. "Website: https://...". Pull those back out here so the new Partner
     * isn't missing data the applicant actually provided.
     */
    private function createPartnerFromRequest(PartnershipRequest $partnershipRequest): void
    {
        $extract = function (string $label) use ($partnershipRequest): ?string {
            if (preg_match('/^' . preg_quote($label, '/') . ':\s*(.+)$/mi', (string) $partnershipRequest->message, $m)) {
                return trim($m[1]);
            }
            return null;
        };

        Partner::create([
            'partnerName'       => $partnershipRequest->organizationName,
            'city'              => $extract('City'),
            'establishmentType' => $extract('Institution type'),
            'partnershipType'   => 'Other', // not collected on the public form — set on the Edit Partner page
            'partnershipStatus' => 'active',
            'countryCode'       => $partnershipRequest->country,
            'website'           => $extract('Website'),
            'logo'              => null,
            'publicationStatus' => 'published',
            'publishedAt'       => now(),
        ]);
    }

    public function rejectPartnership(int $requestID)
    {
        PartnershipRequest::findOrFail($requestID)->update([
            'status'          => 'rejected',
            'handledByUserID' => auth()->id(),
        ]);

        return back()->with('success', 'Partnership request rejected.');
    }

    public function approveDocument(int $documentID)
    {
        Document::findOrFail($documentID)->update([
            'publicationStatus' => 'published',
            'publishedByUserID' => auth()->id(),
            'publishedAt'       => now(),
        ]);

        return back()->with('success', 'Document approved and published.');
    }

    public function rejectDocument(int $documentID)
    {
        Document::findOrFail($documentID)->update([
            'publicationStatus' => 'archived',
        ]);

        return back()->with('success', 'Document rejected.');
    }
}