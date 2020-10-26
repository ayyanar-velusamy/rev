<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSharedBoardPost extends FormRequest
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
            'journey_id' 	=> 'required',
            'group_id' 		=> 'required',
            'content' 		=> 'required|max:1024'
        ];
    }
	
	public function messages(){
		return [
			'journey_id.required'	=>	'Please select a Journey',
			'group_id.required'		=>	'Group ID cannot be empty',
			'content.required'		=>	'Post cannot be empty',
			'content.max'			=>	'Post cannot exceed more than :max characters'
		];
	}
}
