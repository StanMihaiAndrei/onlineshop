<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class CustomVerifyEmail extends VerifyEmailBase
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verificare Adresă Email - ' . config('app.name'))
            ->greeting('Bun venit, ' . $notifiable->name . '!')
            ->line('Vă mulțumim că v-ați înregistrat pe ' . config('app.name') . '.')
            ->line('Vă rugăm să verificați adresa de email făcând clic pe butonul de mai jos.')
            ->action('Verifică Email', $verificationUrl)
            ->line('Acest link de verificare va expira în 60 de minute.')
            ->line('Dacă nu ați creat un cont, vă rugăm să ignorați acest email.')
            ->salutation('Cu respect, Echipa ' . config('app.name'));
    }

    /**
     * Get the verification URL for the given notifiable.
     */
    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}