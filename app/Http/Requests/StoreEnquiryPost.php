<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnquiryPost extends FormRequest
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
        return [
            'name'	  => 'required|alpha_spaces|max:40', 
			'email'   => 'required|email|max:64',
            'phone'  => 'required|min:1000000|max:9999999999999|numeric',
			'comment' => 'required', 
        ];
    }
	
	public function messages()
    {
        return [
			'name.required'	=> 'First Name cannot be empty',
			'name.alpha_spaces'=> 'First Name should contain only alphabets',
			'name.max'		=> 'First Name cannot exceed :max characters', 
			'email.required'		=> 'Email ID cannot be empty',
			'email.email'			=> 'Enter a valid Email ID',
			'email.max'				=> 'Email ID cannot exceed :max characters', 
			'phone.required'		=> 'Phone Number cannot be empty',
			'phone.min'			=> 'Phone Number cannot be less than 7 digits',
			'phone.max'			=> 'Phone Number cannot exceed 13 digits',
			'phone.numeric'		=> 'Phone Number should contain only numbers',
			'comment.required'	=> 'First Name cannot be empty',
		];
	} 
}
