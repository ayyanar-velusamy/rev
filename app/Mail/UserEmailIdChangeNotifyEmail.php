<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserEmailIdChangeNotifyEmail extends Mailable
{
   use Queueable, SerializesModels;
	protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		$subject = 'Email ID changed';
				
	    return $this->view('email_templates.user_email_change_notify_email')
                    ->with(['user' => $this->user])
					->subject($subject);
    }
}