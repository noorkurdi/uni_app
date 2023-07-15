<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules= [
            'full_name'=>['required','min:3','max:255'],
            'uni_number'=>['required','unique:users,uni_number'],
            'password'=>['required','min:4',"max:50","confirmed"],
            'year'=>['required','min:1','max:5'],
        ];
        if($this->routeIs('updateProfile')){
           
                $rules['uni_number'][1]='unique:users,uni_number,'.auth('user')->id();
            
                $rules['password']='current_password';
             
            
                $rules['new_password']=[Rule::requiredIf(request()->password!=""),'min:4','confirmed'];
              
            return $rules;
        }
        return $rules;

    }

    
}
