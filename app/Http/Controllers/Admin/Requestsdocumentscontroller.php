<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use App\Models\Document;
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

        return view('admin.requests-documents', [
            'contactRequests' => $contactRequests,
            'partnerRequests' => $partnerRequests,
            'documents'       => $documents,
        ]);
    }

    public function approvePartnership(int $requestID)
    {
        PartnershipRequest::findOrFail($requestID)->update([
            'status'          => 'accepted',
            'handledByUserID' => auth()->id(),
        ]);

        return back()->with('success', 'Partnership request approved.');
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