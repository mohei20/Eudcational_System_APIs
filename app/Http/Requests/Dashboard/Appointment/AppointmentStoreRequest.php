<?php

namespace App\Http\Requests\Dashboard\Appointment;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentStoreRequest extends FormRequest
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
            'day' => ['required'],
            'from' => ['required', 'date_format:H:i:s'],
            'to' => ['required', 'date_format:H:i:s'],
            'class_room_id' => ['required', 'numeric']
        ];
    }
}
