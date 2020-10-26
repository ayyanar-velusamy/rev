<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJourneyPut extends FormRequest
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
		$journey_id = $this->route('journey');
        $rules = [
            'journey_name'			=>'required|max:64|regex:/^[a-zA-Z0-9\s]+$/',
            'journey_type_id'		=>'required',
            'journey_visibility'	=>'required',
            'journey_description'	=>'required|min:8|max:1024',
        ];
		
		$journey_read = \Illuminate\Support\Facades\Request::get('journey_read');
		$journey_visibility = \Illuminate\Support\Facades\Request::get('journey_visibility');
		$journey_type_id = \Illuminate\Support\Facades\Request::get('journey_type_id'); 
				
		if ($journey_type_id == 2 || $journey_type_id == 3) {
			$rules['journey_read'] = 'required';
			if($journey_read == 'compulsory'){
				$milestone = \App\Model\Milestone::where('journey_id',$journey_id)->whereRead('optional');
				if($milestone->count() > 0){
					$rules['journey_read']  = 'required|min:120';
				}
			}			
		}
		
		if($journey_visibility == 'private'){
			$milestone = \App\Model\Milestone::where('journey_id',$journey_id)->whereVisibility('public');
			if($milestone->count() > 0){
				$rules['journey_visibility']  = 'required|min:120';
			}
		}

		if($journey_visibility == 'public'){
			$milestone = \App\Model\Milestone::where('journey_id',$journey_id)->whereVisibility('public');
			if($milestone->count() <= 0){
				$rules['journey_visibility']  = 'required|max:1';
			}
		}	

		
		if ($journey_type_id != 2 && $journey_type_id != 3) {
			$rules['journey_name'] = 'required|max:64|regex:/^[a-zA-Z0-9\s]+$/|unique:journeys,journey_name,'.$journey_id.',id,deleted_at,NULL';
		}
		
		return $rules;
    }
	
	public function messages()
    {
        $message =  [
			'journey_name.required'	 			=> 'Journey Name cannot be empty',
			'journey_name.regex'				=> 'Journey Name should contain only alphabets and numerics',
			'journey_name.max'					=> 'Journey Name cannot exceed :max characters',
			'journey_name.unique'				=> 'Journey Name already exists',
			'journey_type_id.required'			=> 'Journey Type cannot be empty',
			'journey_visibility.required'		=> 'Visibility cannot be empty',
			'journey_visibility.min'			=> 'All the milestone should be private',
			'journey_visibility.max'			=> 'At least one milestone should be public',
			'journey_description.required'	 	=> 'Description cannot be empty',
			'journey_description.min'			=> 'Description cannot be less than :min characters',
			'journey_description.max'			=> 'Description cannot exceed :max characters',
			'journey_read.required'				=> 'Compulsory or Optional cannot be empty',
			'journey_read.min'					=> 'All the milestone should be compulsory',
		];
		
		// $journey_type_id = \Illuminate\Support\Facades\Request::get('journey_type_id'); 
		
		// if ($journey_type_id != 1) {
			// $message['journey_name.regex'] = 'Journey Name cannot contain special characters';
		// }
		
		return $message;
	}
}
