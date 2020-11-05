<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePagePost extends FormRequest
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
            'title'	=> 'required|alpha_spaces|max:40', 
        ];
    }
	
	public function messages()
    {
        return [
			'title.required'	=> 'First Name cannot be empty',
			'title.alpha_spaces'=> 'First Name should contain only alphabets',
			'title.max'		=> 'First Name cannot exceed :max characters', 
		];
	} 
}
