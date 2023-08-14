<?php

namespace App\Http\Requests\Website\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            
           'expire_month'=>['required', 'regex:/^(0?[1-9]|1[0-2])$/'],
           'expire_year'=>['required', 'regex:/^2\d{3}$/'],
           'cvc'=>['required','numeric','regex:/^[0-9]{3}$/'],
           'name_on_card'=>['required','string'],
           'number_on_card'=>'required|digits:16',
            
        ];
    }
}
