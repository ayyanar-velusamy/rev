<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MilestoneApproveEmail extends Mailable
{
    use Queueable, SerializesModels;

	protected $approval;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($approval)
    {
        $this->approval = $approval;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Milestone Approved';
				
	    return $this->view('email_templates.milestone_approve_email')
                    ->with(['approval' => $this->approval])
					->subject($subject);
    }
}
