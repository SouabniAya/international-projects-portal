<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartnershipRequestRequest;
use App\Models\PartnershipRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class BecomeAPartnerController extends Controller
{
    /**
     * PartnershipRequest only has: requesterName, organizationName, email,
     * phone, country, message, status. The form also collects requester
     * role, institution type, website, city, and areas of interest, none
     * of which have a column to live in — rather than silently dropping
     * them, they're folded into the `message` text as a labeled preamble
     * so nothing the applicant submitted is lost. Flagged in the handover
     * in case dedicated columns are wanted instead.
     */
    public function store(StorePartnershipRequestRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $context = collect([
            'Requester role' => $validated['requester_role'] ?? null,
            'Institution type' => $validated['institution_type'] ?? null,
            'Website' => $validated['website'] ?? null,
            'City' => $validated['city'] ?? null,
            'Areas of interest' => !empty($validated['areas_of_interest'])
                ? implode(', ', $validated['areas_of_interest'])
                : null,
        ])->filter()->map(fn ($value, $label) => "{$label}: {$value}")->implode("\n");

        $message = trim($context . "\n\n" . $validated['message']);

        $partnershipRequest = PartnershipRequest::create([
            'requesterName' => $validated['requester_name'],
            'organizationName' => $validated['organization_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'country' => $validated['country'],
            'message' => $message,
            'submissionDate' => now(),
            'status' => 'new',
        ]);

        // Supporting document upload: stored to disk, but NOT attached as a
        // Document record yet. Document.uploadedByUserID is a required
        // (NOT NULL) FK to User, and this is an anonymous public form with
        // no authenticated user to attribute it to — attaching it properly
        // needs either a nullable uploadedByUserID or a dedicated "public
        // submissions" system user. Flagged in the handover; the file is
        // safely on disk in the meantime and not lost.
        if ($request->hasFile('supporting_document')) {
            $path = $request->file('supporting_document')->store(
                'partnership-requests/' . $partnershipRequest->requestID,
                'public'
            );
            // TODO(Dev1/Dev2): once a resolution is agreed, create the
            // Document row here and attach via $partnershipRequest->documents().
            \Illuminate\Support\Facades\Log::info('Partnership request supporting document stored', [
                'requestID' => $partnershipRequest->requestID,
                'path' => $path,
            ]);
        }

        return back()->with('success', "Application submitted — you'll hear back within two weeks.");
    }
}
