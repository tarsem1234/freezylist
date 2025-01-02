<?php

namespace App\Notifications\Frontend\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

/**
 * Class UserNeedsConfirmation.
 */
class SenderNeedsRegistration extends Notification
{
    use Notifiable,
        Queueable;

    protected $confirmation_code;

    /**
     * UserNeedsConfirmation constructor.
     */
    public function __construct($confirmation_code, $username = null, $property_id = null)
    {

        $this->confirmation_code = $confirmation_code;
        $this->username = $username;
        $this->property_id = $property_id;

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
        //        dump($this->property_id);
        // dd($this->property_id);
        return (new MailMessage)
            ->subject(app_name().': '.trans('exceptions.frontend.auth.confirmation.registraion'))
            ->greeting('Hello! '.$this->username)
//                    ->line($this->property_id?trans('strings.emails.auth.click_to_register'):'test')
            ->line(trans('strings.emails.auth.click_to_register'))
            ->action(trans('buttons.emails.auth.Register'),
                route('frontend.userCreate').'?code='.$notifiable->confirmation_code.'&time='.$notifiable->created_at)
            ->line(trans('strings.emails.auth.thank_you_for_using_app'))
            ->markdown('frontend.mail.registration', ['actionView' => [
                'url' => route('frontend.propertyDetails', ! empty($this->property_id) ? $this->property_id : ''),
                'name' => trans('buttons.emails.auth.View'),
                'property_id' => ! empty($this->property_id) ? $this->property_id : '',
            ]]);
    }
}
