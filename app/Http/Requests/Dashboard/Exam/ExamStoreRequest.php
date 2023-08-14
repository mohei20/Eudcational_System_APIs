<?php

namespace App\Http\Requests\Dashboard\Exam;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ExamStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:200'],
            'start_at' => ['required', 'date_format:Y-m-d H:i'],
            'end_at' => ['required', 'date_format:Y-m-d H:i','after:start_at'],
            'status' => ['required', Rule::in(1, 0)],
            'type' => ['required', Rule::in(1, 0)],
            'class_room_id' => ['required', 'numeric']
        ];
    }
}
