<?php

namespace App\Mail;

use App\Models\ContactRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewContactRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactRequest $contactRequest) {}

    public function build()
    {
        return $this->subject('New contact request: ' . $this->contactRequest->fullName)
            ->view('emails.contact-request');
    }
}