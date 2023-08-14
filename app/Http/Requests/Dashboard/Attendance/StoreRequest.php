<?php

namespace App\Http\Requests\Dashboard\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'class_room_id' => ['required','exists:class_rooms,id'],
            'appointment_id' => ['required','exists:appointments,id'],
            'attendances' => ['required','array']
        ];
    }
}
