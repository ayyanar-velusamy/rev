<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StroeContentAddToPost extends FormRequest
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
			'content_id' 		=> 'required',
			'journey_id' 		=> 'required',
			'start_date' 		=> 'required',
			'target_date' 		=> 'required',
			'visibility' 		=> 'required',
			'payment_type' 		=> 'required'
        ];
		
		//For paid milestone price and approver_id are required fields
		$payment_type = \Illuminate\Support\Facades\Request::get('payment_type');
		if($payment_type != 'Free') {
			$rules['approver_id'] 	= 'required';
		}
		return $rules;
    }
	
	
	
	public function messages()
    {
		$messages = [
			'user.required_without_all'		=> 'Please select a user',
			'group.required_without_all'	=> 'Please select a group',
			'grade.required_without_all'	=> 'Please select a grade',
			'journey_id.required'	 		=> 'Journey cannot be empty',
			'content_type_id.required'	 	=> 'Content Type cannot be empty',
			'title.required'	 			=> 'Title cannot be empty',
			'j_visibility.required'	 		=> 'Visibility of the journey cannot be empty',
			'j_read.required'	 			=> 'Please choose an option',
			'visibility.required'	 		=> 'Visibility cannot be empty',
			'visibility.*.size'	 			=> 'Visibility should be private (For Private Journey)',
			'visibility.*.min'	 			=> 'Visibility at least on should be public (For Public Journey)',
			'visibility.*'	 				=> 'Visibility of the milestone cannot be empty',
			'read.required'	 				=> 'Please choose an option',
			'read.*.required'				=> 'Please choose an option',
			'read.*.size'	 				=> 'All milestones should be compulsory (For Compulsory Journey)',
			'start_date.required'	 		=> 'Start Date cannot be empty',
			'target_date.required'	 		=> 'Targeted Completion Date cannot be empty',
			'target_date.*'	 				=> 'Targeted Completion Date cannot be empty',
			'payment_type.required'	 		=> 'Free or Paid cannot be empty',
			'payment_type.*'		 		=> 'Free or Paid cannot be empty',
			'price.*.required'	 			=> 'Price cannot be empty',
			'price.*.min' 					=> 'Price cannot be zero',
			'price.*.max' 					=> 'Price cannot be more than :max characters',
			'price.*.numeric' 				=> 'Price should only consist of numerics',
			'approver_id.required'	 		=> 'Approver cannot be empty',
			'approver_id.*'	 				=> 'Approver cannot be empty',
		];
				
		return $messages;
	}
}
