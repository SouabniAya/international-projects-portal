<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventRegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $registrations = EventRegistration::with('event.translations')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->toString()))
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = trim($request->string('search')->toString());
                $q->where(function ($inner) use ($search) {
                    $inner->where('fullName', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('event.translations', fn ($t) => $t->where('title', 'like', "%{$search}%"));
                });
            })
            ->orderByDesc('submissionDate')
            ->paginate(15)
            ->withQueryString();

        return view('admin.event-registrations', compact('registrations'));
    }

    public function updateStatus(Request $request, int $registrationID): RedirectResponse
    {
        $validated = $request->validate(['status' => ['required', 'in:pending,approved,rejected']]);
        EventRegistration::findOrFail($registrationID)->update([
            'status' => $validated['status'],
            'handledByUserID' => auth('admin')->id(),
        ]);

        return back()->with('success', 'Registration status updated.');
    }

    public function destroy(int $registrationID): RedirectResponse
    {
        EventRegistration::findOrFail($registrationID)->delete();
        return back()->with('success', 'Registration deleted.');
    }
}
