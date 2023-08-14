<?php

namespace App\Http\Requests\Dashboard\Lesson;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class storeRequest extends FormRequest
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
            'name' => ['required','min:4'],
            'link' => ['required','regex:/(<iframe width)/'],
            'status' => ['required', Rule::in(1, 0)],
            'class_room_id' => ['required','exists:class_rooms,id']
        ];
    }
}
