<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $loginHistory = DB::table('LoginHistory')
            ->where('userID', $user->userID)
            ->orderByDesc('loginTime')
            ->limit(10)
            ->get()
            ->map(function ($log) {
                return [
                    'when' => \Carbon\Carbon::parse($log->loginTime)->format('D, H:i'),
                    'ip' => $log->ipAddress ?? '—',
                    'successful' => (bool) $log->successful,
                ];
            });

        return view('admin.settings', [
            'user' => $user,
            'loginHistory' => $loginHistory,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => ['required', 'email', 'max:255', Rule::unique('User', 'email')->ignore($user->userID, 'userID')],
            'phone'      => 'nullable|string|max:20',
        ]);

        $user->firstName = $validated['first_name'];
        $user->lastName = $validated['last_name'];
        $user->email = $validated['email'];
        $user->phoneNumber = $validated['phone'] ?? null;
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed|regex:/^(?=.*[0-9])(?=.*[\W_]).+$/',
        ], [
            'new_password.regex' => 'The new password must contain at least one number and one symbol.',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }

    /**
     * Simple on/off toggle for twoFactorEnabled. Note: this does NOT set up
     * real TOTP/QR-code 2FA — it only flips the flag on the User row. Full
     * 2FA enrollment (secret generation, QR code, recovery codes) is a
     * separate feature to build later if needed.
     */
    public function toggleTwoFactor(Request $request)
    {
        $user = auth()->user();
        $user->twoFactorEnabled = !$user->twoFactorEnabled;
        $user->save();

        return back()->with('success', $user->twoFactorEnabled
            ? 'Two-factor authentication enabled.'
            : 'Two-factor authentication disabled.');
    }
}