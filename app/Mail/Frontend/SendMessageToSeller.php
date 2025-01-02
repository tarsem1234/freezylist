<?php

namespace App\Mail\Frontend;

use App\Http\Requests\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendContact.
 */
class SendMessageToSeller extends Mailable
{
    use Queueable,
        SerializesModels;

    /**
     * @var Request
     */
    public $sender;

    public $emailSubject;

    public $email;

    public $emailBody;

    public $userName;

    public $view;

    public $signupLink;

    public $partner;

    public $conversationLInk;

    public $message;

    /**
     * SendContact constructor.
     *
     * @param  Request  $request
     */
    public function __construct($to, $userName, $sender, $emailSubject, $emailBody = null, $view = null, $conversationLInk = null, $message = null)
    {
        $this->sender = $sender;
        $this->emailSubject = $emailSubject;
        $this->email = $to;
        $this->emailBody = $emailBody;
        $this->userName = $userName;
        $this->view = $view;
        $this->conversationLInk = $conversationLInk;
        $this->message = $message;
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        return $this->from(config('mail.from.address'), 'Freezylist')
            ->to($this->email)
            ->subject($this->emailSubject)
            ->view($this->view, ['conversationLInk' => $this->conversationLInk, 'sellerMessage' => $this->message, 'senderName' => $this->sender, 'userName' => $this->userName]);
    }
}
