<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ALJMilestoneCompleteEmail extends Mailable
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
        $subject = auth()->user()->full_name.' Completed Milestone '.$this->milestone->title;
				
	    return $this->view('email_templates.alj_milestone_complete_email')
                    ->with(['user_name'=> auth()->user()->full_name,'milestone' => $this->milestone])
					->subject($subject);
    }
}
