<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->image) {
            $question = [
                'id' => $this->id,
                'exam_name' => $this->exam->name,
                'type' => $this->formateQuestionType($this->type),
                'question' => $this->question,
                'point' => $this->point,
                'image' => 'Question_image/' . $this->image,
                'explanation' => $this->explanation,
            ];

            if ($this->options) {
                return array_merge($question, [
                    'options' => OptionResource::collection($this->options)
                ]);
            } else {
                return $question;
            }
        }else{
            $question = [
                'id' => $this->id,
                'exam_name' => $this->exam->name,
                'type' => $this->formateQuestionType($this->type),
                'question' => $this->question,
                'point' => $this->point,
                'explanation' => $this->explanation,
            ];

            if ($this->options) {
                return array_merge($question, [
                    'options' => OptionResource::collection($this->options)
                ]);
            }else {
                return $question;
            }
        }
    }
}
