<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupPost extends FormRequest
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
		$roles = [
            'group_name'     	=> 'required|max:64|regex:/^[a-zA-Z0-9\s]+$/|unique:groups,group_name,NULL,id,deleted_at,NULL',
            'visibility'     	=> 'required',
            'group_description' => 'required|min:8|max:1024'
        ];
		
		$primary_id = \Illuminate\Support\Facades\Request::get('primary_id'); 
		
		if ($primary_id != '') {
			$roles['group_name'] = 'required|max:64|regex:/^[a-zA-Z0-9\s]+$/|unique:groups,group_name,'.decode_url($primary_id);
		}
		
		return $roles;
    }
	
	public function messages()
    {
        $message =  [
			'group_name.required'	 			=> 'Group Name cannot be empty',
			'group_name.regex'					=> 'Group Name should contain only alphabets and numerics',
			'group_name.max'					=> 'Group Name cannot exceed :max characters',
			'group_name.unique'					=> 'Group Name already exists',
			'visibility.required'				=> 'Visibility cannot be empty',
			'group_description.required'	 	=> 'Description cannot be empty',
			'group_description.min'				=> 'Description cannot be less than :min characters',
			'group_description.max'				=> 'Description cannot exceed :max characters',
		];
		
		return $message;
	}
}
