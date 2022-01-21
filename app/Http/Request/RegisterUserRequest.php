<?php

namespace App\Http\Request;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;


class RegisterUserRequest extends FormRequest
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
            'email' => 'required|email|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email',
            'name' => 'required|string|regex:/^([a-z A-Z]+)$/',
            'phone_number' => 'required|string|regex:/^([0-9]+)$/|unique:users,phone_number|min:8|max:14',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-])\S{6,15}$/',
            'country_iso_code' => 'required_with:phone_number|string|regex:/^(\+[0-9]+)$/|max:5',
            'date_of_birth' => 'date|required'
            
        ];
    }
   
}
