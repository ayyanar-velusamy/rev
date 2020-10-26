<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Model\User;
use App\Model\PasswordReset;
use App\Mail\ForgotPasswordEmail;
use App\Notifications\ResetPassword;

class ForgotPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
	
	public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }
	
	//Function to sent forgot password email
	//Input : Email
	//Output : true/false
	//Author : VIjayabaskar
	public function sendResetLinkEmail(Request $request)
    {
		$request->validate(['email' => 'required|email|exists:users,email,deleted_at,NULL'], $this->validationErrorMessages());
		
		$user = User::whereEmail($request->email);
		
		if($user->count() > 0 && $user->first()->status == "active"){
			
			//User Forgot Password Email notification
			Mail::to($user->first())->send(new ForgotPasswordEmail($user->first()));
			//$user->first()->notify(new ResetPassword($user->first()));
			
			$this->response['status']  = true;
			$this->response['redirect']= route('login');
			$this->response['message'] = __('message.password_reset_request_success');
		}else{
			$this->response['status'] = false;
			$this->response['message'] = __('message.account_inactive');
		}
		return $this->response();
    }
	
	protected function validationErrorMessages()
    {
        return [
			'email.required' 	=> "Email ID cannot be empty",
			'email.email' 		=> "Enter a valid Email ID",
			'email.exists' 		=> "Please enter your registered Email ID"
		];
    }
}
