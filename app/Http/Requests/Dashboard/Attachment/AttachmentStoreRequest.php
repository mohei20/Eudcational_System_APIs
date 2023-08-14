<?php

namespace App\Http\Requests\Dashboard\Attachment;

use Illuminate\Foundation\Http\FormRequest;

class AttachmentStoreRequest extends FormRequest
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
            'name' => ['required', 'file', 'mimes:pdf'],
            'description' => ['required', 'string'],
            'class_room_id' => ['required', 'numeric']
        ];
    }
}
