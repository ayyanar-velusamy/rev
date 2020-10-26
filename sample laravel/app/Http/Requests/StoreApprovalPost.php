<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApprovalPost extends FormRequest
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
            'comment' => 'required|max:40',
            'status' => 'required'
        ];
    }
	
	public function messages()
    {
        return [
			'status.required'	 	=> 'Status cannot be empty',
			'comment.required'	 	=> 'Comments cannot be empty',
			'comment.max'	 		=> 'Comments cannot exceed more than :max characters'
		];
	}
}
