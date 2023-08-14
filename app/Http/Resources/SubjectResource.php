<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $academic_year_name = $this->academicYear->name;
        $academic_year = $this->academicYear->year;
        $semester_name = $this->semester->name;

        if ($academic_year_name == '1') {
            $academic_year_name =  $academic_year . " - الصف الاول الثانوى";;
        } elseif ($academic_year_name == '2') {
            $academic_year_name =  $academic_year . " - الصف الثانى الثانوى";
        } elseif ($academic_year_name == '3') {
            $academic_year_name =  $academic_year . " - الصف الثالث الثانوى";
        }

        if ($semester_name == '1') {
            $semester_name = "الفصل الدراسى الاول";
        } elseif ($semester_name == '2') {
            $semester_name = "الفصل الدراسى الثانى";
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status ? 'On' : 'Off',
            'image' => 'Subject_image/' . $this->image,
            'branch_name' => $this->branch->name,
            'academic_year' => $academic_year_name,
            'semester' => $semester_name
        ];
    }
}