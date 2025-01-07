<?php

namespace App\Notifications\Frontend\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

/**
 * Class UserNeedsConfirmation.
 */
class RecieverNeedsLogin extends Notification
{
    use Notifiable,
        Queueable;

    protected $confirmation_code;

    /**
     * UserNeedsConfirmation constructor.
     */
    public function __construct($confirmation_code, $username)
    {
        $this->confirmation_code = $confirmation_code;
        $this->username = $username;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(app_name().': '.trans('exceptions.frontend.auth.confirmation.login'))
            ->line(trans('strings.emails.auth.click_to_login'))
            ->action(trans('buttons.emails.auth.confirm_login'),
                route('frontend.auth.login', $this->confirmation_code))
            ->line(trans('strings.emails.auth.thank_you_for_using_app'));
    }
}
