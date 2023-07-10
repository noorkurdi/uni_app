<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProgramRequest extends FormRequest
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
        $rules=[
            'year_id'=>['required','exists:years,id'],
            'programs.*.subject_name'=>['required','max:255'],
            'programs.*.professore_name'=>['required','max:255'],
            'programs.*.start_time'=>['required'],
            'programs.*.end_time'=>['required'],
            'programs.*.place'=>['required','max:255'],
            'programs.*.day'=>['required','min:1','max:7']
        ];
        if($this->routeIs('editProgram')){
            return [
                'year_id'=>['required','exists:years,id'],
                'subject_name'=>['required','max:255'],
                'professore_name'=>['required','max:255'],
                'start_time'=>['required'],
                'end_time'=>['required'],
                'place'=>['required','max:255'],
                'day'=>['required','min:1','max:7']
            ];
        }
        if($this->routeIs('uploadProgram'))
            return[
                'file'=>['mimes:pdf','max:5000']
            ];
        
        return $rules;
    }
}
