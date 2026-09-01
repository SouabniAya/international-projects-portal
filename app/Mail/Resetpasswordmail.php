<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public string $token)
    {
    }

    public function build()
    {
        return $this->from('MS_nwRMRw@test-65qngkd37zdlwr12.mlsender.net', 'ESI International Projects Portal')
            ->subject('Reset your password — ESI International Projects Portal')
            ->view('emails.reset-password', [
                'resetUrl' => route('password.reset', [
                    'token' => $this->token,
                    'email' => $this->user->email,
                ]),
                'firstName' => $this->user->firstName,
            ]);
    }
}