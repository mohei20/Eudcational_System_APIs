<?php

namespace App\Http\Requests\Dashboard\Option;

use Illuminate\Foundation\Http\FormRequest;

class OptionStoreRequest extends FormRequest
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
            'option' => ['required', 'max:100', 'distinct'],
            // 'is_correct' => ['required', 'boolean'],
            'exam_id' => ['required', 'numeric'],
            'question_id' => ['required', 'numeric']
        ];
    }
}
