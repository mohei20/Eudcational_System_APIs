<?php

namespace App\Http\Requests\Dashboard\Lesson;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => ['min:4'],
            'link' => ['regex:/(<iframe width)/'],
            'status' => [Rule::in(1, 0)],
            'class_room_id' => ['exists:class_rooms,id']
        ];
    }
}
