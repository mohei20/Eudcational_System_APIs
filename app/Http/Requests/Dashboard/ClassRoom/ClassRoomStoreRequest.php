<?php

namespace App\Http\Requests\Dashboard\ClassRoom;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ClassRoomStoreRequest extends FormRequest
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
            'name' => ['required', 'unique:class_rooms'],
            'price' => ['required', 'numeric'],
            'status' => ['required', Rule::in(1, 0), 'numeric'],
            'prerequisite_exam' => [Rule::in(1, 0), 'numeric'],
            'max_capacity' => ['required', 'numeric'],
            'min_grade' => ['required_if:prerequisite_exam,1'],
            'min_selected' => ['required_if:prerequisite_exam,1'],
            'registration_deadline' => ['required', 'date_format:Y-m-d H:i:s'],
            'start_date' => ['required', 'date_format:Y-m-d H:i:s']
        ];
    }
}
