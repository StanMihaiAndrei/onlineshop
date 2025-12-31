<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordBase;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPasswordBase
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Resetare Parolă - ' . config('app.name'))
            ->greeting('Bună, ' . $notifiable->name . '!')
            ->line('Primești acest email pentru că am primit o cerere de resetare a parolei pentru contul tău.')
            ->action('Resetează Parola', $url)
            ->line('Acest link de resetare va expira în ' . config('auth.passwords.'.config('auth.defaults.passwords').'.expire') . ' minute.')
            ->line('Dacă nu ai solicitat resetarea parolei, te rugăm să ignori acest email. Parola ta nu va fi schimbată.')
            ->salutation('Cu respect, Echipa ' . config('app.name'));
    }
}