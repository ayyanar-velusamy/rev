<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContentAssignEmail extends Mailable
{
    use Queueable, SerializesModels;
	protected $milestone;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($milestone)
    {
        $this->milestone = $milestone;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Milestone has been Assigned";
				
	    return $this->view('email_templates.content_assign_email')
                    ->with(['user_name'=> auth()->user()->full_name,'milestone' => $this->milestone])
					->subject($subject);
    }
}
