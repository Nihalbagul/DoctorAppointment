<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $slot;

    public function __construct($slot)
    {
        $this->slot = $slot;
    }

    public function build()
    {
        return $this->view('emails.appointment_confirmation')
                    ->with(['slot' => $this->slot]);
    }
}
