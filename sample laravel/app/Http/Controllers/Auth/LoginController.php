<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }
	
	protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|email|exists:users|string',
            'password' => 'required|string',
        ], $this->validationErrorMessages());
    }
	
	
	public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

		$credentials = $this->credentials($request);
		
        if ($this->guard()->attempt($credentials, $request->filled('remember'))) {
			
			//get user what attempting to login
            $user = \App\Model\User::where($this->username(), $credentials[$this->username()])->first();
			
            //check if user activated & activation required, make autoactivation
            if($user->status != "active") {
                return $this->sendBlockedLoginResponse($request);
            }else{
				$user->login = 'yes';
				$user->last_login_at = get_db_date_time();
				$user->last_login_ip = $request->getClientIp();
                $user->save(); 
			}
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
	
	
	protected function credentials(Request $request)
    {
		$request->request->add(['deleted_at' => null]);
        return $request->only($this->username(), 'password','deleted_at');
    }
	
	   /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	 
	public function sendBlockedLoginResponse(Request $request)
    {
	   $this->guard()->logout();	
	   $this->response['status']  = false;
	   $this->response['message'] = __('message.account_inactive');
	   return $this->response();
    }
	
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

       if($this->guard()->user()){
		  $username = auth()->user()->first_name." ".auth()->user()->last_name;
		  $this->response['status']  = true;
		  $this->response['reload']  = true;
		  $this->response['message'] = str_replace("{username}",$username,__('message.login_success'));
	   }else{
		  $this->response['status'] = false;
		  $this->response['message'] = __('message.login_failed');
	   }
	   return $this->response();
    }
	
	protected function validationErrorMessages()
    {
        return [
			'email.required' 	=> "Email ID cannot be empty",
			'email.email' 		=> "Enter a valid Email ID",
			'email.exists' 		=> "Please enter your registered Email ID",
			'password.required' => "Password cannot be empty"
		];
    }
	
	
	public function logout(Request $request)
    {
		$user = auth()->user();
		$user->login = 'no';
		$user->save();
        $this->guard()->logout();
        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect()->route('login')->with('success_message',__('message.logout_success'));
    }
}
