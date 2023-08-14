<?php

namespace App\Http\Requests\Dashboard\Semester;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SemesterUpdateRequest extends FormRequest
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
            'name' => ['required'],
            'status' => ['required', Rule::in(1, 0)],
            'academic_year_id' => ['required', 'numeric'],

        ];
    }
}
