<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMilestoneNotePost extends FormRequest
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
            'notes'	 =>'nullable|max:40|regex:/^[\pL\pM\pN\s]+$/u',
        ];
    }
	
	public function messages()
    {
		return  [
			'notes.max'	 					=> 'Notes cannot be more than :max characters',
			'notes.regex'	 				=> 'Notes should contain only Alphabets and Numerics',
		];
	}
}
