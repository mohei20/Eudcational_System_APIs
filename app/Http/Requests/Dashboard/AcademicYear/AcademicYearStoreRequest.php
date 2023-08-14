<?php

namespace App\Http\Requests\Dashboard\AcademicYear;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class AcademicYearStoreRequest extends FormRequest
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

            'name' => ['required', Rule::in(1, 2, 3)],
            'year' => ['required', 'date_format:Y'],
            'branch_id' => ['required', 'numeric']

        ];
    }
}
