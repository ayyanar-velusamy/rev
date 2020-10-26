<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StroeJourneyAssignPost extends FormRequest
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
			'user' 				=> 'required_without_all:group,grade',
			'group' 			=> 'required_without_all:user,grade',
			'grade' 			=> 'required_without_all:user,group',
            'journey_id'		=> 'required',
            'j_visibility'		=> 'required',
            'j_read'			=> 'required',
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
		$j_read = \Illuminate\Support\Facades\Request::get('j_read');
		$m_visibility = \Illuminate\Support\Facades\Request::get('visibility');
		$read = \Illuminate\Support\Facades\Request::get('read');
		
		if($j_visibility == 'private'){
			foreach($m_visibility as $key=>$val){
				$rule = 'visibility.'.$key; 
				if($val != "" && $val != 'private'){
					$rules[$rule] 	   = 'size:1';
				}
			}			
		}

		if($j_visibility == 'public'){
			if(!in_array("public", $m_visibility)){
				foreach($m_visibility as $key=>$val){
					$rule = 'visibility.'.$key; 
					$rules[$rule] 	   = 'min:200';
				}
			}
		}
		
		if($j_read == 'compulsory'){
			foreach($read as $key=>$val){
				$rule = 'read.'.$key; 
				if($val != "" && $val != 'compulsory'){
					$rules[$rule] 	   = 'size:1';
				}
			}			
		}
		
		//For paid milestone price and approver_id are required fields
		$payment_type = \Illuminate\Support\Facades\Request::get('payment_type');
		foreach($payment_type as $key=>$val){
			if($val != 'free') {
				$rule1 = 'approver_id.'.$key; 
				$rule2 = 'price.'.$key; 
				$rules[$rule1] 			= 'required';
				$rules[$rule2] 			= 'required|min:1|max:9999999|numeric';
			}
		}	
		
		return $rules;
    }
	
	public function messages()
    {
		$messages = [
			'user.required_without_all'		=> 'Please select a user',
			'group.required_without_all'	=> 'Please select a group',
			'grade.required_without_all'	=> 'Please select a grade',
			'journey_id.required'	 		=> 'Journey id cannot be empty',
			'content_type_id.required'	 	=> 'Milestone Type cannot be empty',
			'title.required'	 			=> 'Title cannot be empty',
			'j_visibility.required'	 		=> 'Visibility of the journey cannot be empty',
			'j_read.required'	 			=> 'Please choose an option',
			'visibility.required'	 		=> 'Visibility of the milestone cannot be empty',
			'visibility.*.size'	 			=> 'Visibility should be private (For Private Journey)',
			'visibility.*.min'	 			=> 'Visibility at least on should be public (For Public Journey)',
			'visibility.*'	 				=> 'Visibility of the milestone cannot be empty',
			'read.required'	 				=> 'Please choose an option',
			'read.*.required'				=> 'Please choose an option',
			'read.*.size'	 				=> 'All milestones should be compulsory (For Compulsory Journey)',
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
