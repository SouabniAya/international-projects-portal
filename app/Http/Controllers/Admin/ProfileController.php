<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth('admin')->user();

        $initials = strtoupper(
            substr($user->firstName ?? 'A', 0, 1) . substr($user->lastName ?? 'U', 0, 1)
        );

        $recentActivity = DB::table('AuditLog')
            ->where('userID', $user->userID)
            ->orderByDesc('timestamp')
            ->limit(5)
            ->get()
            ->map(function ($log) {
                return [
                    'description' => $log->description,
                    'when' => \Carbon\Carbon::parse($log->timestamp)->diffForHumans(),
                ];
            });

        return view('admin.profile', [
            'user' => $user,
            'initials' => $initials,
            'recentActivity' => $recentActivity,
        ]);
    }
}