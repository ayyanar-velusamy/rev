<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContentPost extends FormRequest
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
            'content_type_id'	=>'required',
            'title'				=>'required|min:4|max:64|regex:/^[\pL\pM\pN\s]+$/u|unique:contents,title,NULL,id,deleted_at,NULL',
            'description'		=>'nullable|max:1024',
            'length'			=>'nullable|numeric',
            'difficulty'		=>'required',
            'payment_type'		=>'required',
            'tags'				=>'nullable'
        ];
		
		//For paid milestone price and approver_id are required fields
		$payment_type = \Illuminate\Support\Facades\Request::get('payment_type');
		if($payment_type != 'free') {
			$rules['price'] 		= 'required|min:1|max:9999999|numeric';
			$rules['approver_id'] 	= 'required';
		}
		
		//For video,podcast,book and course type length field required
	    $content_type_id = \Illuminate\Support\Facades\Request::get('content_type_id');
		// if(in_array($content_type_id, [2,3,4,5])){
			 // $rules['length'] 		= 'required|nullable|numeric';
		// }
		
		//For provider field required except Event type
		if($content_type_id == 3){
			//Episode
			$rules['provider'] 	= 'required|max:64';
		}
		
		//For provider field required except Event type
		if($content_type_id == 4){
			//Author
			$rules['provider'] 	= 'required|max:40|alpha_spaces';
		}
		
		//For provider field required except Event type
		if(!in_array($content_type_id, [3,4,6])){
			$rules['provider'] 	= 'required|min:4|max:64|regex:/^[\pL\pM\pN\s]+$/u';
		}
		
		//For url field required except book type
		if($content_type_id != 4 ){			 
            $rules['url'] = 'required|min:4|max:2048|url|regex:/^\S*$/u';
		}		
	
		return $rules;
    }
	
	public function messages()
    {
		$messages = [
			'content_type_id.required'	 	=> 'Content Type cannot be empty',
			'url.required'	 				=> 'URL cannot be empty',
			'url.min'	 					=> 'URL cannot be less than :min characters',
			'url.max'	 					=> 'URL cannot be more than :max characters',
			'url.regex' 					=> 'URL cannot contain spaces',
			'url.url'	 					=> 'Enter a valid URL',
			'title.required'	 			=> 'Title cannot be empty',
			'title.regex'	 				=> 'Title should contain only alphabets and numerics',
			'title.min'	 					=> 'Title cannot be less than :min characters',
			'title.max'	 					=> 'Title cannot be more than :max characters',
			'title.unique'	 				=> 'Title already exists',
			'provider.required'	 			=> 'Provider cannot be empty',
			'provider.alpha_spaces'	 		=> 'Provider should contain only alphabets',
			'provider.min'	 				=> 'Provider cannot be less than :min characters',
			'provider.max'	 				=> 'Provider cannot be more than :max characters',
			'provider.regex'	 			=> 'Provider should contain only alphabets and numerics',
			'description.required'	 		=> 'Description cannot be empty',
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
		
		$content_type_id = \Illuminate\Support\Facades\Request::get('content_type_id');
						
		if($content_type_id == 3){
			$messages['provider.required']  	= 'Episode cannot be empty';
			$messages['provider.alpha_spaces']  = 'Episode should contain only alphabets and spaces';
			$messages['provider.min']  			= 'Episode cannot be less than :min characters';
			$messages['provider.max']  			= 'Episode cannot be more than :max characters';
		}
		
		if($content_type_id == 4){
			$messages['provider.required']  	= 'Author cannot be empty';
			$messages['provider.alpha_spaces']  = 'Author should contain only alphabets and spaces';
			$messages['provider.min']  			= 'Author cannot be less than :min characters';
			$messages['provider.max']  			= 'Author cannot be more than :max characters';
		}
		
		return $messages;
	}
}
