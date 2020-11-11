<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnquiryMail extends Mailable
{
    use Queueable, SerializesModels;

	protected $enquiry;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($enquiry)
    {
		$this->enquiry = $enquiry;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		$subject = 'Enquiry';
				
	    return $this->view('email_templates.enquiry_email')
                    ->with(['enquiry' => $this->enquiry])
					->subject($subject);
    }
}
