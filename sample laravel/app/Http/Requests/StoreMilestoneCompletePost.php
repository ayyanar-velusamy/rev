<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMilestoneCompletePost extends FormRequest
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
            'milestone_id' => 'required',
            'rating'	   => 'required'
        ];
    }
	
	public function messages()
    {
        return [
			'rating.required'	 	=> 'Rating cannot be empty',
			'milestone_id.required'	=> 'Milestone id cannot be empty'
		];
	}
}