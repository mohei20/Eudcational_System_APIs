<?php

namespace App\Http\Requests\Dashboard\Question;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionStoreRequest extends FormRequest
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
            'question' => ['required', 'string', 'max:300'],
            'type' => ['required', Rule::in(0, 1, 2)],
            'point' => ['required', 'numeric'],
            'image' => ['mimes:png,jpg'],
            'explanation' => ['max:100'],
            'exam_id' => ['required', 'numeric']
        ];
    }
}
