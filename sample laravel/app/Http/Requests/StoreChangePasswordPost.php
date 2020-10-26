<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChangePasswordPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
			'current_password'      => 'required',
            'password' => 'required|min:8|max:16|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/|confirmed|different:current_password',
            'password_confirmation' => 'required',
		];
		$current_password = \Illuminate\Support\Facades\Request::get('current_password');
		
		if(!\Illuminate\Support\Facades\Hash::check($current_password, auth()->user()->password)){
			$rules['current_password'] 	= 'required|min:124';
		}		
		return  $rules;
    }
	
	public function messages()
    {
        return [
			'current_password.required'			=> "Current Password cannot be empty",
			'current_password.min'				=> "Entered Current Password is incorrect! Retry",
			'password.required' 				=> "New Password cannot be empty",
			'password.min' 						=> "New Password cannot be  less than 8 characters",
			'password.max' 						=> "New Password cannot exceed 16 characters",
			'password.regex' 					=> "New Password must contain at least 1 digit, 1 lowercase letter,1 uppercase letter and 1 special character",
			'password_confirmation.required' 	=> "Re-Enter Password cannot be empty",
			'password.confirmed' 				=> "New Password mismatch! Retry",
			'password.different' 				=> "New Password can't be same as current password",
		];
    }
}
