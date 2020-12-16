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
			'menu_en'	=> 'required', 
			'menu_es'	=> 'required', 
			'menu_ar'	=> 'required', 
			'content_en'	=> 'required', 
			'content_es'	=> 'required', 
			'content_ar'	=> 'required', 
        ];
    }
	
	public function messages()
    {
        return [
			'title.required'	=> 'First Name cannot be empty', 
			'parent_menu.required'	=> 'Please select parent menu', 
			'menu_en.required'	=> 'English Menu cannot be empty',
			'menu_es.required'	=> 'Spanish Menu cannot be empty',
			'menu_ar.required'	=> 'Arabic Menu cannot be empty', 
			'content_en.required'	=> 'English content cannot be empty',
			'content_es.required'	=> 'Spanish content cannot be empty',
			'content_ar.required'	=> 'Arabic content cannot be empty',
		];
	} 
}
