<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJourneyPost extends FormRequest
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
            'journey_name'				=>'required|max:64|regex:/^[a-zA-Z0-9\s]+$/|unique:journeys,journey_name,NULL,id,deleted_at,NULL',
            'journey_type_id'			=>'required',
            'journey_visibility'		=>'required',
            'journey_description'		=>'required|min:8|max:1024',
        ];
		
		$primary_id = \Illuminate\Support\Facades\Request::get('primary_id'); 
		
		if ($primary_id != '') {
			$rules['journey_name'] = 'required|max:64|regex:/^[a-zA-Z0-9\s]+$/|unique:journeys,journey_name,'.decode_url($primary_id).',id,deleted_at,NULL';
		}
				
		$journey_read = \Illuminate\Support\Facades\Request::get('journey_read');
		$journey_visibility = \Illuminate\Support\Facades\Request::get('journey_visibility');
		$journey_type_id = \Illuminate\Support\Facades\Request::get('journey_type_id'); 
				
		if ($journey_type_id == 2) {
			$rules['journey_read'] = 'required';
			
			if ($primary_id != '') {
				if($journey_read == 'compulsory'){
					$milestone = \App\Model\Milestone::where('journey_id',decode_url($primary_id))->whereRead('optional');
					if($milestone->count() > 0){
						$rules['journey_read']  = 'required|min:120';
					}
				}	
			}
		}

		if($journey_visibility == 'private'){
			if ($primary_id != '') {
				$milestone = \App\Model\Milestone::where('journey_id',decode_url($primary_id))->whereVisibility('public');
				if($milestone->count() > 0){
					$rules['journey_visibility']  = 'required|min:120';
				}
			}
		}
		
		return $rules;
    }
	
	public function messages()
    {
        $message = [
			'journey_name.required'	 			=> 'Journey Name cannot be empty',
			'journey_name.regex'			    => 'Journey Name should contain only alphabets and numerics',
			'journey_name.max'					=> 'Journey Name cannot exceed :max characters',
			'journey_name.unique'				=> 'Journey Name already exists',
			'journey_type_id.required'			=> 'Journey Type cannot be empty',
			'journey_visibility.required'				=> 'Visibility cannot be empty',
			'journey_visibility.min'					=> 'All the milestone should be private',
			'journey_description.required'	 	=> 'Description cannot be empty',
			'journey_description.min'			=> 'Description cannot be less than :min characters',
			'journey_description.max'			=> 'Description cannot exceed :max characters',
			'journey_read.required'						=> 'Compulsory or Optional cannot be empty',
			'journey_read.min'							=> 'All the milestone should be compulsory',
		];
		
		// $journey_type_id = \Illuminate\Support\Facades\Request::get('journey_type_id'); 
		
		// if ($journey_type_id != 1) {
			// $message['journey_name.regex'] = 'Journey Name cannot contain special characters';
		// }
		
		return $message;
	}
}
