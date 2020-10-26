<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDuplicateJourneyPost extends FormRequest
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
             'journey_name'				=>'required|max:64|regex:/^[a-zA-Z0-9\s]+$/|unique:journeys,journey_name,NULL,id,deleted_at,NULL',
        ];
    }
	
	public function messages()
    {
        $message = [
			'journey_name.required'	 			=> 'Learning Journey Name cannot be empty',
			'journey_name.regex'			    => 'Learning Journey Name cannot contain special characters',
			'journey_name.max'					=> 'Learning Journey Name cannot exceed :max characters',
			'journey_name.unique'				=> 'Learning Journey Name already exists',
		];
		
		return $message;
	}
}
