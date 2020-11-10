<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSliderPost extends FormRequest
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
            'name'	=> 'required|alpha_spaces|max:40', 
            'image'	=> 'required', 
        ];
    }
	
	public function messages()
    {
        return [
			'name.required'	=> 'Slider Name cannot be empty',
			'name.alpha_spaces'=> 'Slider Name should contain only alphabets',
			'name.max'		=> 'Slider Name cannot exceed :max characters', 
			'image.required'	=> 'Slider Image cannot be empty',
		];
	} 
}
