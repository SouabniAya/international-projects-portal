<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle a staff/admin login attempt.
     *
     * Uses the "admin" guard (matches the remember_admin_* cookie already
     * configured in config/auth.php — see note below if that guard
     * doesn't exist yet).
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');
        $user = User::where('email', $credentials['email'])->first();

        // Account disabled — reject before attempting auth, and log it.
        if ($user && ! $user->isActive()) {
            $this->logAttempt($user->userID, false, 'Account disabled');

            throw ValidationException::withMessages([
                'email' => 'This account has been disabled. Contact an administrator.',
            ]);
        }

        if (! Auth::guard('admin')->attempt($credentials, $remember)) {
            if ($user) {
                $this->logAttempt($user->userID, false, 'Invalid password');
            }

            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        $request->session()->regenerate();

        $this->logAttempt(Auth::guard('admin')->id(), true);

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function logAttempt(?int $userID, bool $successful, ?string $failureReason = null): void
    {
        if (! $userID) {
            return;
        }

        LoginHistory::create([
            'loginTime'     => now(),
            'userID'        => $userID,
            'successful'    => $successful,
            'ipAddress'     => request()->ip(),
            'failureReason' => $failureReason,
        ]);
    }
}