<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GroupMemberAddEmail extends Mailable
{
    use Queueable, SerializesModels;
	protected $group;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($group)
    {
        $this->group = $group;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'You have been added to the '.$this->group['group_name'].' Group';
				
	    return $this->view('email_templates.group_member_add_email')
                    ->with(['user_name'=> auth()->user()->full_name,'group' => $this->group])
					->subject($subject);
    }
}
