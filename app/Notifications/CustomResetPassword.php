<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordBase;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\ResetPasswordMail;

class CustomResetPassword extends ResetPasswordBase
{
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $expiresIn = config('auth.passwords.'.config('auth.defaults.passwords').'.expire');

        return (new ResetPasswordMail($notifiable, $url, $expiresIn))
            ->to($notifiable->email);
    }
}