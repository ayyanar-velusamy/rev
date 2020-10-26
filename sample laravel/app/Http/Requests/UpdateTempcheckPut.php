<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Model\Tempcheck;
class UpdateTempcheckPut extends FormRequest
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
	   $tempcheck_id = $this->route('tempcheck');
	   return [
            'question'  	=> 'required|unique:tempchecks,question,'.$tempcheck_id.',id,deleted_at,NULL',
            'frequency'     => 'required',
            'frequency_day' => 'required',
            'due_date' => 'required'
        ];
    }
}
