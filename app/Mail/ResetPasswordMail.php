<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $resetUrl;
    public $expiresIn;

    public function __construct($user, $resetUrl, $expiresIn = 60)
    {
        $this->user = $user;
        $this->resetUrl = $resetUrl;
        $this->expiresIn = $expiresIn;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Resetare Parolă - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reset-password',
        );
    }
}