<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public static function notifyAdministrators(string $type, string $content): void
    {
        $adminUsers = User::whereHas('roles', function ($query) {
            $query->whereRaw("LOWER(roleName) LIKE ?", ['%admin%'])
                ->orWhereRaw("LOWER(roleName) = ?", ['international relations officer']);
        })->get(['userID']);

        foreach ($adminUsers as $admin) {
            Notification::create([
                'type' => $type,
                'content' => $content,
                'isRead' => false,
                'createdAt' => now(),
                'userID' => $admin->userID,
            ]);
        }
    }
}
