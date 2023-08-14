<?php

namespace App\Http\Requests\Dashboard\Branch;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BranchUpdateRequest extends FormRequest
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
            'name' => ['required','unique:branches,id,:'.$this->id],
            'address' => ['required'],
            'phone_number' => ['required','regex:/(01)[0-9]{9}/','size:11'],
            'hot_line' => ['required','numeric'],
            'map_location' => ['required','regex:/(<iframe src)/'],
            'status' => ['required', Rule::in(1, 0)]
        ];
    }
}
