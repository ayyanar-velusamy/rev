<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserEmailIdChangeVerificationEmail extends Mailable
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
				
	    return $this->view('email_templates.user_email_change_verify_email')
                    ->with(['user' => $this->user, 'link'=> $this->generateUrl()])
					->subject($subject);
    }
	
	private function generateUrl(){
		return url('verify/email/'.$this->user->change_email_token.'?email='.$this->user->email);
	}
}
