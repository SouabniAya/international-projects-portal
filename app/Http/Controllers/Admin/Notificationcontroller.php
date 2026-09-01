<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Simple notifications feed backed by ContactRequest — each submitted
     * contact request becomes a "notification" row. No dedicated
     * Notification table needed for this first version.
     */
    public function index()
    {
        $notifications = DB::table('ContactRequest')
            ->orderByDesc('submissionDate')
            ->paginate(10)
            ->through(fn ($c) => [
                'id' => $c->requestID,
                'title' => 'New message from ' . $c->fullName,
                'desc' => $c->message ?? '',
                'status' => $c->status === 'new' ? 'unread' : 'read',
                'status_label' => $c->status === 'new' ? 'Unread' : 'Read',
                'datetime' => \Carbon\Carbon::parse($c->submissionDate)->format('M j, Y g:i A'),
            ]);

        return view('admin.notifications', compact('notifications'));
    }

    public function show(int $id)
    {
        $c = DB::table('ContactRequest')->where('requestID', $id)->first();

        abort_unless($c, 404);

        if ($c->status === 'new') {
            DB::table('ContactRequest')->where('requestID', $id)->update(['status' => 'handled']);
            $c->status = 'handled';
        }

        $subjectLabel = DB::table('ContactSubjectRoutingTranslation')
            ->where('subjectCode', $c->subjectCode)
            ->whereIn('languageCode', [app()->getLocale(), 'en'])
            ->orderByRaw("languageCode = ? DESC", [app()->getLocale()])
            ->value('subjectLabel');

        $notification = [
            'id' => $c->requestID,
            'title' => 'Message from ' . $c->fullName,
            'fullName' => $c->fullName,
            'email' => $c->email,
            'phone' => $c->phone ?? null,
            'subject' => $subjectLabel ?: 'General inquiry',
            'message' => $c->message ?? '',
            'status' => $c->status === 'new' ? 'unread' : 'read',
            'status_label' => $c->status === 'new' ? 'Unread' : 'Read',
            'datetime' => \Carbon\Carbon::parse($c->submissionDate)->format('M j, Y g:i A'),
        ];

        return view('admin.notification-details', compact('notification'));
    }
}