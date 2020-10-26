<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRolePost extends FormRequest
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
            'name'     		=> 'required|alpha_spaces|max:40|unique:roles,name,NULL,id,deleted_at,NULL',
            'status'    	=> 'required',
            'permissions'   => 'required',
        ];
    }
	
	public function messages()
    {
        return [
            'name.required'     	=> 'Role Name cannot be empty',
            'name.max'     			=> 'Role Name cannot exceed more than 40 characters',
            'name.unique'     		=> 'Role Name already exists',
            'name.alpha_spaces'     => 'Role Name should contain only Alphabets',
            'status.required'   	=> 'Please choose a status',
            'permissions.required'  => 'Please choose a permission',
        ];
    }
}
