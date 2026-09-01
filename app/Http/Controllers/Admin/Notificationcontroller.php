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
                'id' => $c->contactRequestID ?? $c->id ?? null,
                'title' => 'Contact request from ' . $c->fullName,
                'desc' => $c->message ?? '',
                'status' => $c->status === 'new' ? 'Unread' : 'Read',
                'datetime' => \Carbon\Carbon::parse($c->submissionDate)->format('M j, Y g:i A'),
            ]);

        return view('admin.notifications', compact('notifications'));
    }
}