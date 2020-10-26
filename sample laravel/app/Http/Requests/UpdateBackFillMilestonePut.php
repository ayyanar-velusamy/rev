<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBackFillMilestonePut extends FormRequest
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
	    $milestone_id = decode_url($this->route('id'));
		$rules = [
            'content_type_id'	=>'required',
			'title'				=>'required|min:4|max:64|regex:/^[\pL\pM\pN\s]+$/u|unique:milestones,title,'.$milestone_id.',id,deleted_at,NULL',
            'description'		=>'required|min:8|max:1024',
            'start_date'		=>'nullable|date',
            'end_date'			=>'required|date|after_or_equal:start_date',
            'difficulty'		=>'required',
            'tags'				=>'nullable'
        ];
		
		return $rules;
    }
	
	public function messages()
    {
        $messages =  [
			'content_type_id.required'	 	=> 'Milestone Type cannot be empty',
			'url.required'	 				=> 'URL cannot be empty',
			'url.min'	 					=> 'URL cannot be less than :min characters',
			'url.max'	 					=> 'URL cannot be more than :max characters',
			'url.regex' 					=> 'URL cannot contain spaces',
			'url.url'	 					=> 'Enter a valid URL',
			'title.required'	 			=> 'Milestone Name cannot be empty',
			'title.unique'	 				=> 'Milestone Name already exists',
			'title.regex'	 				=> 'Milestone Name should contain only alphabets and numerics',
			'title.min'	 					=> 'Milestone Name cannot be less than :min characters',
			'title.max'	 					=> 'Milestone Name cannot be more than :max characters',
			'title.unique'	 				=> 'Milestone Name already exists',
			'provider.required'	 			=> 'Provider cannot be empty',
			'provider.alpha_spaces'	 		=> 'Provider should contain only alphabets and spaces',
			'provider.min'	 				=> 'Provider cannot be less than :min characters',
			'provider.max'	 				=> 'Provider cannot be more than :max characters',
			'provider.regex'	 			=> 'Provider should contain only alphabets and numerics',
			'description.required'	 		=> 'Description cannot be empty',
			'description.min'	 			=> 'Description cannot be less than :min characters',
			'description.max'	 			=> 'Description cannot be more than :max characters',
			'notes.max'	 					=> 'Notes cannot be more than :max characters',
			'notes.regex'	 				=> 'Notes should contain only alphabets and numerics',
			'visibility.required'	 		=> 'Visibility cannot be empty',
			'visibility.min'	 			=> 'Visibility cannot be public (For private journey)',
			'visibility.numeric'	 		=> 'At least one milestone should be public (For public Journey)',
			'read.required'	 				=> 'Compulsory or Optional cannot be empty',
			'read.min'	 					=> 'All milestones should be compulsory (For Compulsory Journey)',
			'difficulty.required'	 		=> 'Difficulty cannot be empty',
			'start_date.required'	 		=> 'Start Date cannot be empty',
			'end_date.required'	 			=> 'Targeted Completion Date cannot be empty',
			'end_date.after_or_equal'	 	=> 'Target date should not be less than the start date',
			'payment_type.required'	 		=> 'Free or Paid cannot be empty',
			'price.required'	 			=> 'Price cannot be empty',
			'price.min'	 					=> 'Price cannot be zero',
			'price.max'	 					=> 'Price cannot be more than :max characters',
			'price.numeric'	 				=> 'Price should only consist of numerics',
			'approver_id.required'	 		=> 'Approver cannot be empty',
			'length.required'	 		    => 'Length cannot be empty',
		];
		
		return $messages;
	}
}
