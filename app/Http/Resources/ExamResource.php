<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $arr = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'start_at' => $this->examDateFormate($this->start_at),
            'end_at' => $this->examDateFormate($this->end_at),
            'status' => $this->status ? 'Puplished' : 'unPulished',
            'type' => $this->type ? 'Prerequest Exam':'Normal Exam' ,
            'classroom_name' => $this->classRoom->name,
        ];

        if ($this->questions_count !== null) {
            $newArr = [
                'count_questions' => $this->questions_count
            ];
            $arr = array_merge($arr, $newArr);
        }
        if ($this->questions_sum_point !== null) {
            $newArr = [
                'questions_sum_point' => number_format($this->questions_sum_point,2)
            ];
            $arr = array_merge($arr, $newArr);
        }
        if ($this->examResult !== null) {

            try {
                $newArr = [
                    'Result' => [
                        "total_score" => $this->examResult[0]->total_score,
                        'submit_at' => $this->examDateFormate($this->examResult[0]->created_at)
                    ]
                ];
                $arr = array_merge($arr, $newArr);
            } catch (\Exception $e) {
                return $arr;
            }
        }
        return $arr;
    }
}
