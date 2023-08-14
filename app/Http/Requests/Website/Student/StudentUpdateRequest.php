<?php

namespace App\Http\Requests\Website\Student;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'f_name' => 'required|string|between:2,100|regex:/^[\p{Arabic} ]+$/u',
            'm_name' => 'required|string|between:2,100|regex:/^[\p{Arabic} ]+$/u',
            'l_name' => 'required|string|between:2,100|regex:/^[\p{Arabic} ]+$/u',
            'phone_number' => ['required','regex:/(01)[0-9]{9}/','size:11'],
            'email' => 'required|string|email|max:100|unique:students,id,:'.$this->id,
            'guardian_number' => ['required','regex:/(01)[0-9]{9}/','size:11','different:phone_number'],
            'year' => 'required',
            'month' => ['required','numeric','max:12'],
            'day' => ['required','numeric','max:32'],
            'acedemic_year' => ['required','numeric'],
            'division' =>  ['required', Rule::in(1, 2, 3, 4, 5)],
            'national_id_card' => ['mimes:jpg,png,jpeg'],
            'governorate_id' => ['required']
        ];
    }
}
