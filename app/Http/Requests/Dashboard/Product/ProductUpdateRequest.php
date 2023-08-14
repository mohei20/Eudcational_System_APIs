<?php

namespace App\Http\Requests\Dashboard\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
class ProductUpdateRequest extends FormRequest
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
            'name' => ['required','unique:products,id,:'.$this->id],
            'subject_id'=>['required','numeric'],
            'teacher_id'=>['required','numeric'],
            'category_id'=>['numeric'],
            'status' => ['required', Rule::in(1, 0)],
            'price'=>'required|numeric|min:1',
            'quantity'=>'required|numeric|min:1',
            'description'=>['required'],
            'image'=>['required','mimes:jpg,png,jpeg'],
           
        ];
    }
}
