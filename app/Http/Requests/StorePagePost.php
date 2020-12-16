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
            'title'	=> 'required', 
			'parent_menu'	=> 'required', 
			'content_en'	=> 'required', 
			'content_fr'	=> 'required', 
        ];
    }
	
	public function messages()
    {
        return [
			'title.required'	=> 'First Name cannot be empty', 
			'parent_menu.required'	=> 'Please select parent menu', 
			'content_ev.required'	=> 'English content cannot be empty',
			'content_fr.required'	=> 'French content cannot be empty',
		];
	} 
}
