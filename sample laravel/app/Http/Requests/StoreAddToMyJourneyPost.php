<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddToMyJourneyPost extends FormRequest
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
        $rules =  [
            'journey_id'		=> 'required',
            'j_visibility'		=> 'required',
            'target_date' 		=> 'required|array',
			'target_date.*' 	=> 'required',
			'read' 				=> 'required|array',
			'read.*' 			=> 'required',
			'payment_type' 		=> 'required|array',
			'payment_type.*' 	=> 'required',
			'visibility' 		=> 'required|array',
			'visibility.*' 		=> 'required',
        ];
		
		$j_visibility = \Illuminate\Support\Facades\Request::get('j_visibility');
		$m_visibility = \Illuminate\Support\Facades\Request::get('visibility');
		
		if($j_visibility == 'private'){
			foreach($m_visibility as $key=>$val){
				$rule = 'visibility.'.$key; 
				if($val != "" && $val != 'private'){
					$rules[$rule] 			= 'size:1';
				}
			}			
		}	
		
		//For paid milestone price and approver_id are required fields
		$payment_type = \Illuminate\Support\Facades\Request::get('payment_type');
		foreach($payment_type as $key=>$val){
			if($val != 'free') {
				$rule1 = 'approver_id.'.$key; 
				//$rule2 = 'price.'.$key; 
				$rules[$rule1] 			= 'required';
				//$rules[$rule2] 			= 'required|min:1|max:9999999|numeric';
			}
		}
		
		return $rules;
    }
	
	public function messages()
    {
		$messages = [
			'journey_id.required'	 		=> 'Journey id cannot be empty',
			'content_type_id.required'	 	=> 'Milestone Type cannot be empty',
			'title.required'	 			=> 'Title cannot be empty',
			'j_visibility.required'	 		=> 'Visibility of the journey cannot be empty',
			'visibility.required'	 		=> 'Visibility of the milestone cannot be empty',
			'visibility.*.size'	 			=> 'Visibility should be private (For Private Journey)',
			'visibility.*'	 				=> 'Visibility of the milestone cannot be empty',
			'read.required'	 				=> 'Please choose an option',
			'read.*'	 					=> 'Please choose an option',
			'target_date.required'	 		=> 'Targeted Completion Date cannot be empty',
			'target_date.*'	 				=> 'Targeted Completion Date cannot be empty',
			'payment_type.required'	 		=> 'Free or Paid cannot be empty',
			'payment_type.*'		 		=> 'Free or Paid cannot be empty',
			'price.required'	 			=> 'Price cannot be empty',
			'price.*'	 					=> 'Price cannot be empty',
			'approver_id.required'	 		=> 'Approver cannot be empty',
			'approver_id.*'	 				=> 'Approver cannot be empty',
		];	
		
		return $messages;
	}
}
