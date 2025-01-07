<?php

namespace App\Jobs;

use App\Mail\Frontend\SaleAgreementLandlordMailing;
use App\Services\EmailLogService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

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

    public $allUser;

    public $offer;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($allUser, $sender, $emailSubject, $viewOfferLink = null, $propertyLink = null, $view = null, $offer = null)
    {
        $this->sender = $sender;
        $this->emailSubject = $emailSubject;
        //        $this->email         = $to;
        //        $this->emailBody     = $emailBody;
        $this->propertyLink = $propertyLink;
        $this->viewOfferLink = $viewOfferLink;
        //        $this->userName      = $userName;
        $this->view = $view;
        $this->allUser = $allUser;
        $this->offer = $offer;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        foreach ($this->allUser as $userName => $userEmail) {
            $emailBody = 'Hello '.$userName.'Signature Process completed for sale agreement property and ready to download the documents. Thank You';

            Mail::to($userEmail)->send(new SaleAgreementLandlordMailing($userEmail, $userName, $this->sender, $this->emailSubject, $emailBody, $this->viewOfferLink,
                $this->propertyLink, $this->view));

            $saveLog = new EmailLogService;
            $saveLog->saveLog($this->offer->property->id, $this->offer->sender_id, $this->offer->owner_id, $this->emailSubject, $emailBody, $this->propertyLink,
                url()->previous());
        }
    }
}
