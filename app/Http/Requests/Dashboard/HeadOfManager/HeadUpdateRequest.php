<?php

namespace App\Http\Requests\Dashboard\HeadOfManager;

use Illuminate\Foundation\Http\FormRequest;

class HeadUpdateRequest extends FormRequest
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
            'name' => 'required|string|between:2,100',
            'email' => ['required','email','max:100','unique:users,id,:'.$this->id],
            'password' => 'required|string|confirmed|min:6',
        ];
    }
}
