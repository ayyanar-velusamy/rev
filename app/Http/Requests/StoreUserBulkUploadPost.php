<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserBulkUploadPost extends FormRequest
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
            'bulkimphrcsv'      => 'required',
            'bulkimphrzip'      => 'mimes:zip|max:4194304'
        ];
		
    }
	
	public function messages()
    {
        return [
            'bulkimphrcsv.required' => 'Please upload a file',
            'bulkimphrcsv.mimes'    => 'Invalid file format',
            'bulkimphrzip.mimes'    => 'Invalid file format',
            'bulkimphrzip.max'    	=> 'File size cannot exceed 4GB'
        ];
		
    }
	
	
}
