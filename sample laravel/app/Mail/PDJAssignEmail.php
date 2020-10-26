<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PDJAssignEmail extends Mailable
{
    use Queueable, SerializesModels;
	protected $journey;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($journey)
    {
        $this->journey = $journey;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Journey has been Assigned';
				
	    return $this->view('email_templates.pdj_assign_email')
                    ->with(['user_name'=> auth()->user()->full_name,'journey' => $this->journey])
					->subject($subject);
    }
}
