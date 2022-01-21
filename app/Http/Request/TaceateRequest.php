<?php

namespace App\Http\Request;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;


class TaceateRequest extends FormRequest
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
             'task_board_id'=>'required|numeric|exists:App\Models\Taskboard,id',
            'name' => 'required',
          
            
        ];
    }
   
}
