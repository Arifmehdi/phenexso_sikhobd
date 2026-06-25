<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApiResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;
    public static $createUrlCallback;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Build the reset link from the current request's base URL (dynamic host/scheme),
        // pointing to our web reset form route: /reset-password/{token}?email=...
        $request = request();
        $base = ($request && $request->getHttpHost())
            ? $request->getSchemeAndHttpHost()      // e.g. https://sikhobd.com
            : rtrim(config('app.url'), '/');         // fallback for queue/CLI

        $resetUrl = $base . '/reset-password/' . $this->token
            . '?email=' . urlencode($notifiable->getEmailForPasswordReset());

        return (new MailMessage)
                    ->subject('Reset Password Notification')
                    ->greeting('Hello!')
                    ->line('You are receiving this email because we received a password reset request for your account.')
                    ->action('Reset Password', $resetUrl)
                    ->line('This password reset link will expire in ' . config('auth.passwords.users.expire') . ' minutes.')
                    ->line('If you did not request a password reset, no further action is required.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
