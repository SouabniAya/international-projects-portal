<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Always respond the same way whether or not the email exists,
     * so the form can't be used to enumerate staff accounts.
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->isActive()) {
            $rawToken = Str::random(64);

            $user->forceFill([
                'passwordResetToken' => Hash::make($rawToken),
                'tokenExpiresAt'     => now()->addHour(),
            ])->save();

            Mail::to($user->email)->send(new ResetPasswordMail($user, $rawToken));
        }

        return back()->with('status', 'If an account exists for this email, a reset link has been sent.');
    }

    public function showResetForm(string $token, Request $request)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function reset(Request $request): RedirectResponse
    {
        $request->validate([
            'token'    => ['required', 'string'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user
            || ! $user->passwordResetToken
            || ! $user->tokenExpiresAt
            || $user->tokenExpiresAt->isPast()
            || ! Hash::check($request->token, $user->passwordResetToken)
        ) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => 'This password reset link is invalid or has expired.',
            ]);
        }

        $user->forceFill([
            'password'            => Hash::make($request->password),
            'passwordResetToken'  => null,
            'tokenExpiresAt'      => null,
        ])->save();

        return redirect()->route('login')->with('status', 'Your password has been reset. You can now sign in.');
    }
}