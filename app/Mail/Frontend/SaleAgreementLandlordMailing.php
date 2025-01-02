<?php

namespace App\Mail\Frontend;

use App\Http\Requests\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendContact.
 */
class SaleAgreementLandlordMailing extends Mailable
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

    public $viewOfferLink;

    public $propertyLink;

    public $userName;

    public $view;

    public $signupLink;

    public $partner;

    /**
     * SendContact constructor.
     *
     * @param  Request  $request
     */
    public function __construct($to, $userName, $sender, $emailSubject,
        $emailBody = null, $viewOfferLink = null,
        $propertyLink = null, $view = null,
        $signupLink = null, $partner = null)
    {
        $this->sender = $sender;
        $this->emailSubject = $emailSubject;
        $this->email = $to;
        $this->emailBody = $emailBody;
        $this->propertyLink = $propertyLink;
        $this->viewOfferLink = $viewOfferLink;
        $this->userName = $userName;
        $this->view = $view;
        $this->signupLink = $signupLink;
        $this->partner = $partner;
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        return $this->from(config('mail.from.address'), 'Freezylist')
            ->to($this->email)
            ->subject($this->emailSubject)
            ->view($this->view,
                ['updated' => $this->emailBody,
                    'propertyLink' => $this->propertyLink,
                    'partner' => $this->partner,
                    'viewOfferLink' => $this->viewOfferLink]);
    }
}
