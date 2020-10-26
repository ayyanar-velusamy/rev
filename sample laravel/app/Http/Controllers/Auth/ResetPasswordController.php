<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;
use App\Model\PasswordReset;
use App\Model\User;

class ResetPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
	
	
	//Function to render reset password page
	//Input : token
	//Output : render view
	//Author : VIjayabaskar 
	public function showResetForm(Request $request, $token = null)
    {
		$valid = PasswordReset::whereToken($token)->first();
		//Check token exist in database and expire time
		if($valid && !Carbon::parse($valid->created_at)->addSeconds(config('auth.passwords.users.expire')*60)->isPast()){
			$user = User::whereEmail($valid->email)->first();
			return view('auth.passwords.reset')->with(
				['token' => $token, 'email' => $request->email,'user'=>$user]
			);
		}else{			
			return view('errors.linkExpired');
		}
    }
	
	//Function to render set password page
	//Input : token
	//Output : render view
	//Author : VIjayabaskar 
	public function showSetForm(Request $request, $token = null)
    {
		$valid = PasswordReset::whereToken($token)->first();		
		//Check token exist in database
		if($valid){
			$user = User::whereEmail($valid->email)->first();
			return view('auth.passwords.set')->with(
				['token' => $token, 'email' => $request->email,'user'=>$user]
			);
		}else{			
			return view('errors.linkExpired');
		}
    }	
	
	//Function to render reset password page
	//Input : token
	//Output : render view
	//Author : VIjayabaskar 
	public function verifyEmail(Request $request, $token = null)
    {
		$valid = User::whereChangeEmailToken($token)->first();
		
		//Check token exist in database and expire time
		if($valid && !Carbon::parse($valid->changed_at)->addSeconds(config('auth.passwords.users.expire')*60)->isPast()){
			$valid->email = $valid->change_email;
			$valid->change_email_token = null;
			$valid->changed_at = null;
			if($valid->save()){							
				return redirect()->route('login')->with('success_message',str_replace("{username}",$valid->first_name." ".$valid->last_name,__('message.user_new_email_verified')));
			}
		}else{			
			return view('errors.linkExpired');
		}
    }
	
	//Function to set new password form User invite email link
	//Input : token and Password
	//Output : NA
	//Author : VIjayabaskar 
	public function setPassword(Request $request, $token = null){

		$request->validate($this->roles(), $this->validationErrorMessages());
		
		$token_user = PasswordReset::whereToken($request->token);
		
		$user = User::whereEmail($token_user->first()->email)->first();
		
		if($user){
			$user->password = Hash::make($request->password);
			$user->save();
			$token_user->delete();
			$this->response['status'] = true;
			$this->response['redirect']= route('login');
			$this->response['message'] = __('message.password_set_success');
		}else{
			$this->response['status'] = false;
			$this->response['message'] = __('message.something_went_wrong');
		}
		
		return $this->response();
	}
	
	//Function to reset password form Forgot Password email link
	//Input : token and Password
	//Output : NA
	//Author : VIjayabaskar 
	public function resetPassword(Request $request, $token = null){

		$request->validate($this->roles(), $this->validationErrorMessages());
		
		$token_user = PasswordReset::whereToken($request->token);
		if($token_user->count() > 0 ){
			$user = User::whereEmail($token_user->first()->email)->first();
			
			if($user){
				$user->password = Hash::make($request->password);
				$user->save();
				$token_user->delete();
				$this->response['status']   = true;
				$this->response['redirect'] = route('login');
				$this->response['message']  = __('message.password_reset_success');
			}
		}else{
			$this->response['status'] = false;
			$this->response['message'] = __('message.something_went_wrong');
		}
		return $this->response();
	}
	
	
	protected function roles()
    {
        return [
            'token' => 'required',
            'password' => 'required|min:8|max:16|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/|confirmed',
            'password_confirmation' => 'required',
			];
    }
	
	protected function validationErrorMessages()
    {
        return [
			'password.required'				 	=> "Password cannot be empty",
			'password.min' 						=> "Password cannot be  less than 8 characters",
			'password.max' 						=> "Password cannot exceed 16 characters",
			'password.regex' 					=> "Password must contain at least 1 digit, 1 lowercase letter,1 uppercase letter and 1 special character",
			'password_confirmation.required' 	=>  "Confirm Password cannot be empty",
			'password.confirmed' 				=> "Password mismatch! Retry",
		];
    }
	
}
