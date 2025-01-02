<?php

namespace App\Notifications\Frontend\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

/**
 * Class UserNeedsConfirmation.
 */
class SenderNeedsConfirmation extends Notification
{
    use Notifiable,
        Queueable;

    protected $confirmation_code;

    /**
     * UserNeedsConfirmation constructor.
     */
    public function __construct($confirmation_code)
    {
        $this->confirmation_code = $confirmation_code;
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
            ->subject(app_name().': '.trans('exceptions.frontend.auth.confirmation.confirm'))
            ->line(trans('strings.emails.auth.click_to_confirm'))
            ->action(trans('buttons.emails.auth.confirm_account'),
                route('frontend.account.confirm', $this->confirmation_code))
            ->line(trans('strings.emails.auth.thank_you_for_using_app'));
    }
}
