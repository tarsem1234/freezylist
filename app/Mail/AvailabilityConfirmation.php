<?php

namespace App\Mail;

use App\Models\Access\User\User;
use App\Models\PropertyAvailability;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AvailabilityConfirmation extends Mailable
{
    use Queueable,
        SerializesModels;

    public $availability;

    public $user;

    public function __construct(PropertyAvailability $availability, User $user)
    {
        $this->availability = $availability;
        $this->user = $user;
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        return $this->markdown('frontend.mail.availabilty_confirmation');
    }
}
