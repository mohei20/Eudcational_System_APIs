<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->prerequisite_exam) {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'price' => $this->price,
                'prerequisite_exam' => $this->prerequisite_exam ? 'On' : 'Off',
                'status' => $this->status ? 'On' : 'Off',
                'registration_deadline' => $this->registration_deadline,
                'start_date' => $this->start_date,
                'max_capacity' => $this->max_capacity,
                'min_grade' => $this->min_grade,
                'min_selected' => $this->min_selected,
                'branch_name' => $this->branch->name,
                'subject_name' => $this->subject->name,
                'teacher_name' => $this->teacher->name
            ];
        } else {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'price' => $this->price,
                'prerequisite_exam' => $this->prerequisite_exam ? 'On' : 'Off',
                'status' => $this->status ? 'On' : 'Off',
                'registration_deadline' => $this->registration_deadline,
                'start_date' => $this->start_date,
                'max_capacity' => $this->max_capacity,
                'branch_name' => $this->branch->name,
                'subject_name' => $this->subject->name,
                'teacher_name' => $this->teacher->name
            ];
        }
    }
}
