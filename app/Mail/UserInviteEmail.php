<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Password;
use App\Model\PasswordReset;

class UserInviteEmail extends Mailable
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
		$subject = 'Welcome Email';
				
	    return $this->view('email_templates.invite_email')
                    ->with(['user' => $this->user,'link'=> $this->generateUrl()])
					->subject($subject);
    }
	
	private function generateToken(){
		//Generate a new reset password token
		$token = app('auth.password.broker')->createToken($this->user);
		PasswordReset::where(['email'=>$this->user->email])->update(['token'=>$token]);
		return $token; 
		
	}
	
	private function generateUrl(){
		return url('password/set/'.$this->generateToken().'?email='.$this->user->email);
	}
}
