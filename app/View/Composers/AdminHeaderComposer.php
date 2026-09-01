<?php

namespace App\View\Composers;

use App\Models\Notification;
use Illuminate\View\View;

/**
 * Feeds resources/views/components/admin-header.blade.php.
 *
 * The header already reads the logged-in user's name straight off
 * auth()->user() inline, so this composer only needs to supply what the
 * component can't get from a single model call:
 *  - unread notification count, for the little red dot on the bell icon
 *  - the current admin's role name, instead of the hardcoded "Administrator"
 *    text (a user can hold more than one Role — the first assigned one is
 *    shown, which matches the single-line UI the header already has).
 */
class AdminHeaderComposer
{
    public function compose(View $view): void
    {
        $user = auth('admin')->user();

        $unreadNotificationsCount = $user
            ? Notification::forUser($user->userID)->unread()->count()
            : 0;

        $roleName = $user?->roles()->first()?->roleName ?? 'Administrator';

        $view->with([
            'unreadNotificationsCount' => $unreadNotificationsCount,
            'currentRoleName' => $roleName,
        ]);
    }
}
